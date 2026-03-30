<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EstadiController;
use App\Http\Controllers\Api\EquipController;
use App\Http\Controllers\Api\JugadoraController;
use App\Http\Controllers\Api\PartitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 🔓 RUTES PÚBLIQUES (sense auth)
Route::name('api.')->group(function () {
    // Jugadors - només lectura pública
    Route::apiResource('/jugadores', JugadoraController::class)->only(['index', 'show']);

    // Estadis - només lectura pública
    Route::apiResource('/estadis', EstadiController::class)->only(['index', 'show']);

    // Equips - només lectura pública
    Route::apiResource('/equips', EquipController::class)->only(['index', 'show']);

    // Partits - només lectura pública
    Route::apiResource('/partits', PartitController::class)->only(['index', 'show']);
});

// 🔐 RUTES PROTEGIDES (amb auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    // Estadis - CRUD complet (admin only per policies)
    Route::apiResource('/estadis', EstadiController::class)->except(['index', 'show']);

    // Equips - CRUD complet (admin create/delete, admin/manager update per policies)
    Route::apiResource('/equips', EquipController::class)->except(['index', 'show']);

    // Partits - update només (admin/arbitre per policies)
    Route::apiResource('/partits', PartitController::class)->except(['index', 'show']);

    // Jugadors - CRUD complet (admin/manager per policies)
    Route::apiResource('/jugadores', JugadoraController::class)->except(['index', 'show']);
});

Route::post('login', [AuthController::class, 'login'])->middleware('api');
Route::post('register', [AuthController::class, 'register'])->middleware('api');

<?php

use App\Http\Controllers\EquipController;
use App\Http\Controllers\EstadiController;
use App\Http\Controllers\JugadoraController;
use App\Http\Controllers\PartitController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', RoleMiddleware::class . ':administrador'])->group(function () {
    Route::resource('/equips', EquipController::class)->except(['index', 'show']);
    Route::resource('/estadis', EstadiController::class)->except(['index', 'show']);
    Route::resource('/jugadores', JugadoraController::class)->except(['index', 'show']);
    Route::resource('/partits', PartitController::class)->except(['index', 'show']);
});
Route::middleware(['auth', RoleMiddleware::class . ':manager'])->group(function () {
    Route::resource('/equips', EquipController::class)->only(['update', 'edit']);
    Route::resource('/estadis', EstadiController::class)->only(['edit', 'update']);
    Route::resource('/jugadores', JugadoraController::class)->only(['index', 'show']);
    Route::resource('/partits', PartitController::class)->only(['index', 'show']);
});
Route::resource('/equips', EquipController::class)->only(['index', 'show']);
Route::resource('/estadis', EstadiController::class)->only(['index', 'show']);
Route::resource('/jugadores', JugadoraController::class)->only(['index', 'show']);
Route::resource('/partits', PartitController::class)->only(['index', 'show']);

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ca', 'es'])) {
        Session::put('locale', $locale);
    }
    return back(); // Torna a la pàgina anterior
})->name('setLocale');

require __DIR__ . '/auth.php';

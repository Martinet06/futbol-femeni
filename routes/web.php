<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipController;
use App\Http\Controllers\EstadiController;
use App\Http\Controllers\JugadoraController;
use App\Http\Controllers\PartitController;

Route::get('/', fn() => "Benvingut a la Guia d'Equips de Futbol Femení!");
Route::resource('equips', EquipController::class)->only('index', 'create', 'show', 'store');
Route::resource('estadis', EstadiController::class)->only('index', 'create', 'show', 'store');
Route::resource('jugadores', JugadoraController::class)->only('index', 'create', 'show', 'store');
Route::resource('partits', PartitController::class)->only('index', 'create', 'show', 'store');

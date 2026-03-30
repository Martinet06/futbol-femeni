<?php

use App\Http\Controllers\EquipController;
use App\Http\Controllers\EstadiController;
use App\Http\Controllers\JugadoraController;
use App\Http\Controllers\PartitController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AIController;
use App\Livewire\ClassificacioComponent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Pàgina inicial
Route::get('/', function () {
    return view('dashboard');
});

// Dashboard (només usuaris verificats)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Perfil d'usuari
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =================================================================
// 1. RUTES PÚBLIQUES (Definides PRIMER i de forma individual)
// =================================================================
// Definim index/show de jugadores manualment per evitar conflictes amb el resource d'admin
Route::get('/jugadores', [JugadoraController::class, 'index'])->name('jugadores.index');
Route::get('/jugadores/{jugadora}', [JugadoraController::class, 'show'])->name('jugadores.show')->where('jugadora', '[0-9]+');

Route::get('/estadis', [EstadiController::class, 'index'])->name('estadis.index');
Route::get('/estadis/{estadi}', [EstadiController::class, 'show'])
    ->name('estadis.show')
    ->where('estadi', '[0-9]+');
// Altres rutes públiques
Route::resource('equips', EquipController::class)->only(['index', 'show']);
Route::resource('partits', PartitController::class)
    ->only(['index', 'show'])
    ->where(['partit' => '[0-9]+']);

// Històric de partits
Route::get('/historic', [PartitController::class, 'historic'])->name('partits.historic');


// =================================================================
// 2. RUTES PROTEGIDES PER ROL
// =================================================================

// ⚖️ Àrbitres (role = 'arbitre') - Definides ABANS de les d'admin per prioritat
Route::middleware(['auth'])->group(function () {
    // Àrbitres poden editar resultats dels seus partits
    Route::get('partits/{partit}/edit', [PartitController::class, 'edit'])->name('partits.edit')->middleware('role:arbitre');
    Route::put('partits/{partit}', [PartitController::class, 'update'])->name('partits.update')->middleware('role:arbitre,admin');
});

// 🔐 Administradors (role = 'admin')
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Equips: tot excepte index/show (ja definits com a públics)
    Route::resource('equips', EquipController::class)->except(['index', 'show']);

    // Partits: sense update/store/destroy per a admin (update via àrbitre)
    Route::resource('partits', PartitController::class)
        ->except(['index', 'show', 'update'])
        ->where(['partit' => '[0-9]+']);

    // Estadis: tot
    Route::resource('estadis', EstadiController::class)->where(['estadi' => '[0-9]+']);

    // IA: generar descripcions
    Route::post('equips/{equip}/ai-description', [AIController::class, 'generateEquipDescription'])->name('equips.ai-description');
    Route::post('estadis/{estadi}/ai-description', [AIController::class, 'generateEstadiDescription'])->name('estadis.ai-description');
});

// 👔 Managers (role = 'manager') i Administradors per a jugadores
Route::middleware(['auth'])->group(function () {
    // Managers i admin poden crear/editar/eliminar jugadores
    Route::post('jugadores', [JugadoraController::class, 'store'])->name('jugadores.store')->middleware('role:manager,admin');
    Route::get('jugadores/create', [JugadoraController::class, 'create'])->name('jugadores.create')->middleware('role:manager,admin');
    Route::get('jugadores/{jugadora}/edit', [JugadoraController::class, 'edit'])->name('jugadores.edit')->middleware('role:manager,admin');
    Route::put('jugadores/{jugadora}', [JugadoraController::class, 'update'])->name('jugadores.update')->middleware('role:manager,admin');
    Route::delete('jugadores/{jugadora}', [JugadoraController::class, 'destroy'])->name('jugadores.destroy')->middleware('role:manager,admin');
});

// 👔 Managers (role = 'manager') - Altres rutes
Route::middleware(['auth', 'role:manager'])->group(function () {
    // Només poden editar el seu propi equip
    Route::get('equips/{equip}/edit', [EquipController::class, 'edit'])->name('equips.edit');
    Route::put('equips/{equip}', [EquipController::class, 'update'])->name('equips.update');

    // Partits: només veure
    /* Route::get('partits', [PartitController::class, 'index'])->name('partits.index');
    Route::get('partits/{partit}', [PartitController::class, 'show'])->name('partits.show'); */
});

// =================================================================
// 3. ALTRES RUTES
// =================================================================


// Google
Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

// Canvi d'idioma
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ca', 'es'])) {
        Session::put('locale', $locale);
    }
    return back();
})->name('setLocale');

// Classificació (Livewire)
Route::get('/classificacio', ClassificacioComponent::class)->name('classificacio');

require __DIR__ . '/auth.php';

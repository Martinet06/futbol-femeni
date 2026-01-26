<?php

use App\Http\Controllers\EquipController;
use App\Http\Controllers\EstadiController;
use App\Http\Controllers\JugadoraController;
use App\Http\Controllers\PartitController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;
use App\Livewire\ClassificacioComponent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Pàgina inicial
Route::get('/', function () {
    return view('home');
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

// === RUTES PROTEGIDES PER ROL ===

// 🔐 Administradors (role = 'admin')
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    // Equips: tot excepte index/show (ja definits més avall com a públics)
    Route::resource('equips', EquipController::class)->except(['index', 'show']);

    // Estadis: tot
    Route::resource('estadis', EstadiController::class);

    // Jugadores: tot excepte index/show
    Route::resource('jugadores', JugadoraController::class)->except(['index', 'show']);

    // Partits: NO es permet crear ni esborrar manualment → només update de resultat si cal (però millor via àrbitre)
    // Per seguretat, no donem accés a store/destroy aquí. Si cal, es fa des d’un sistema intern.
});

// 👔 Managers (role = 'manager')
Route::middleware(['auth', RoleMiddleware::class . ':manager'])->group(function () {
    // Només poden editar el seu propi equip
    Route::get('equips/{equip}/edit', [EquipController::class, 'edit'])->name('equips.edit');
    Route::put('equips/{equip}', [EquipController::class, 'update'])->name('equips.update');

    // Jugadores: només veure i gestionar les seves (create/store/update/destroy)
    Route::get('jugadores/create', [JugadoraController::class, 'create'])->name('jugadores.create');
    Route::post('jugadores', [JugadoraController::class, 'store'])->name('jugadores.store');
    Route::get('jugadores/{jugadora}/edit', [JugadoraController::class, 'edit'])->name('jugadores.edit');
    Route::put('jugadores/{jugadora}', [JugadoraController::class, 'update'])->name('jugadores.update');
    Route::delete('jugadores/{jugadora}', [JugadoraController::class, 'destroy'])->name('jugadores.destroy');

    // Partits: només veure
    Route::get('partits', [PartitController::class, 'index'])->name('partits.index');
    Route::get('partits/{partit}', [PartitController::class, 'show'])->name('partits.show');
});

// ⚖️ Àrbitres (role = 'arbitre')
Route::middleware(['auth', RoleMiddleware::class . ':arbitre'])->group(function () {
    // Només poden veure i actualitzar els resultats dels partits on són àrbitres
    Route::get('partits', [PartitController::class, 'index'])->name('partits.index');
    Route::get('partits/{partit}', [PartitController::class, 'show'])->name('partits.show');
    Route::get('partits/{partit}/edit', [PartitController::class, 'edit'])->name('partits.edit');
    Route::put('partits/{partit}', [PartitController::class, 'update'])->name('partits.update');
});

// === RUTES PÚBLIQUES (accessibles per a tothom) ===
Route::resource('equips', EquipController::class)->only(['index', 'show']);
Route::resource('estadis', EstadiController::class)->only(['index', 'show']);
Route::resource('jugadores', JugadoraController::class)->only(['index', 'show']);
Route::resource('partits', PartitController::class)->only(['index', 'show']);

// Històric de partits
Route::get('/historic', [PartitController::class, 'historic'])->name('partits.historic');

// Canvi d'idioma
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ca', 'es'])) {
        Session::put('locale', $locale);
    }
    return back();
})->name('setLocale');

Route::get('/classificacio', ClassificacioComponent::class)->name('classificacio');

require __DIR__ . '/auth.php';

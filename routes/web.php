<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrajetController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReservationStatusController;
use App\Http\Controllers\TrajetSearchController;
use App\Http\Controllers\TrajetCompatibiliteController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [TrajetController::class, 'dashboard'])
        ->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Employés
    Route::resource('employes', EmployeController::class);

    // Recherche
    Route::get('/trajets/search', [TrajetSearchController::class, 'index'])
        ->name('trajets.search');

    // Trajets
    Route::resource('trajets', TrajetController::class);

    // Compatibilité IA
    Route::post('/trajets/{trajet}/compatibilite', [TrajetCompatibiliteController::class, 'calculer'])
        ->name('trajets.compatibilite');

    // Réservations
    Route::resource('reservations', ReservationController::class);

    Route::get('/conducteur/reservations', [ReservationController::class, 'gestionConducteur'])
        ->name('reservations.conducteur.index');

    Route::put('/reservations/{reservation}/statut', [ReservationStatusController::class, 'update'])
        ->name('reservations.statut.update');
});

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\EmployeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrajetController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TrajetSearchController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReservationStatusController;
Route::get('/conducteur/reservations', [ReservationController::class, 'gestionConducteur'])
    ->name('reservations.conducteur.index');
Route::resource('employes', EmployeController::class);
Route::put('/reservations/{reservation}/statut', [ReservationStatusController::class, 'update'])
    ->name('reservations.statut.update');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [TrajetController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // recherche des trajets
Route::get('/trajets/search', [TrajetSearchController::class, 'index'])
    ->name('trajets.search');

    // Trajets
    Route::resource('trajets', TrajetController::class);

    // Réservations
    Route::resource('reservations', ReservationController::class);

});

require __DIR__.'/auth.php';
<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateReservationStatutRequest;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Support\Facades\Gate;

class ReservationStatusController extends Controller
{
    public function __construct(
        private readonly ReservationService $reservationService
    ) {
    }

    /**
     * Le conducteur confirme ou refuse une réservation sur l'un de ses trajets.
     */
    public function update(UpdateReservationStatutRequest $request, Reservation $reservation)
    {
        Gate::authorize('gerer', $reservation);

        try {
            $this->reservationService->changerStatut($reservation, $request->validated()['statut']);
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['statut' => $e->getMessage()]);
        }

        return back()->with('success', 'Statut de la réservation mis à jour.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Models\Trajet;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReservationController extends Controller
{
    public function __construct(
        private readonly ReservationService $reservationService
    ) {
    }

    public function index(Request $request)
    {
        $reservations = $request->user()
            ->reservations()
            ->with('trajet')
            ->latest('date_reservation')
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    public function store(StoreReservationRequest $request)
    {
        $trajet = Trajet::findOrFail($request->validated()['trajet_id']);

        try {
            $this->reservationService->creerReservation($trajet, $request->user());
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['trajet_id' => $e->getMessage()]);
        }

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Réservation créée avec succès, en attente de confirmation du conducteur.');
    }

    public function destroy(Reservation $reservation)
    {
        Gate::authorize('annuler', $reservation);

        try {
            $this->reservationService->changerStatut($reservation, Reservation::STATUT_ANNULEE);
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['reservation' => $e->getMessage()]);
        }

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Réservation annulée.');
    }

    /**
     * Vue "gestion" pour le conducteur : tous ses trajets avec les
     * réservations reçues sur chacun d'eux (C2.7).
     */
    public function gestionConducteur(Request $request)
    {
        $trajets = $request->user()
            ->trajetsConduits()
            ->with(['reservations.passager'])
            ->latest('date_depart')
            ->get();

        return view('reservations.manage', compact('trajets'));
    }
}

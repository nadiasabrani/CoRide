<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Trajet;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with(['user', 'trajet'])->get();

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trajets = Trajet::all();

        return view('reservations.create', compact('trajets'));
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'trajet_id' => 'required|exists:trajets,id',
            'nombre_places' => 'required|integer|min:1',
        ]);

        Reservation::create([
            'user_id' => auth()->id(),
            'trajet_id' => $request->trajet_id,
            'nombre_places' => $request->nombre_places,
            'statut' => 'en_attente',
        ]);

        return redirect()->route('reservations.index')
                         ->with('success', 'Réservation créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        $trajets = Trajet::all();

        return view('reservations.edit', compact('reservation', 'trajets'));
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'trajet_id' => 'required|exists:trajets,id',
            'nombre_places' => 'required|integer|min:1',
            'statut' => 'required|string',
        ]);

        $reservation->update([
            'trajet_id' => $request->trajet_id,
            'nombre_places' => $request->nombre_places,
            'statut' => $request->statut,
        ]);

        return redirect()->route('reservations.index')
                         ->with('success', 'Réservation modifiée avec succès.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')
                         ->with('success', 'Réservation supprimée avec succès.');
    }
}

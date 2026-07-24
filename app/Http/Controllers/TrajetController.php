<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use App\Http\Requests\StoreTrajetRequest;
use App\Http\Requests\UpdateTrajetRequest;

class TrajetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trajets = Trajet::with(['conducteur', 'reservations', 'entreprise'])
            ->orderBy('date_depart')
            ->get();

        return view('trajets.index', compact('trajets'));
    }
    public function dashboard()
    {
        $employe = auth()->user();

        $trajets = Trajet::with(['reservations'])
            ->where('conducteur_id', $employe->id)
            ->orderBy('date_depart')
            ->get();

        // Statistiques pour le conducteur
        $totalReservationsRecues = $trajets->sum(fn ($t) => $t->reservations->count());
        $reservationsEnAttente   = $trajets->sum(
            fn ($t) => $t->reservations->where('statut', \App\Models\Reservation::STATUT_EN_ATTENTE)->count()
        );

        // Statistiques pour le passager
        $mesReservations = \App\Models\Reservation::where('passager_id', $employe->id)->count();

        return view('dashboard', compact(
            'employe',
            'trajets',
            'totalReservationsRecues',
            'reservationsEnAttente',
            'mesReservations'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('trajets.create');
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreTrajetRequest $request)
    {
        $jours = $request->input('jours_recurrence');

        Trajet::create([
            'entreprise_id'    => auth()->user()->entreprise_id,
            'conducteur_id'    => auth()->id(),
            'depart'           => $request->depart,
            'destination'      => $request->destination,
            'date_depart'      => $request->date_depart,
            'heure_depart'     => $request->heure_depart,
            'prix'             => $request->prix,
            'places'           => $request->places,
            'jours_recurrence' => !empty($jours) ? $jours : null,
        ]);

        return redirect()->route('trajets.index')
            ->with('success', 'Trajet publié avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trajet $trajet)
    {
        $trajet->load(['conducteur.entreprise', 'reservations.passager', 'entreprise']);
        return view('trajets.show', compact('trajet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trajet $trajet)
    {
        return view('trajets.edit', compact('trajet'));
    }

    /**
     * Update the specified resource.
     */
    public function update(UpdateTrajetRequest $request, Trajet $trajet)
    {
        $this->authorize('update', $trajet);

        $jours = $request->input('jours_recurrence');

        $trajet->update([
            'depart'           => $request->depart,
            'destination'      => $request->destination,
            'date_depart'      => $request->date_depart,
            'heure_depart'     => $request->heure_depart,
            'prix'             => $request->prix,
            'places'           => $request->places,
            'jours_recurrence' => !empty($jours) ? $jours : null,
        ]);

        return redirect()->route('trajets.show', $trajet)
            ->with('success', 'Trajet modifié avec succès.');
    }

    /**
     * Remove the specified resource.
     */
   public function destroy(Trajet $trajet)
{
    $this->authorize('delete', $trajet);

    $trajet->delete();

    return redirect()->route('trajets.index')
        ->with('success', 'Trajet supprimé avec succès.');
}

}

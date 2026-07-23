<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use Illuminate\Http\Request;

class TrajetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trajets = Trajet::with(['entreprise', 'conducteur'])->get();

        return view('trajets.index', compact('trajets'));
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
    public function store(Request $request)
    {
        $request->validate([
            'depart' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'date_depart' => 'required|date',
            'heure_depart' => 'required',
            'prix' => 'required|numeric',
            'places' => 'required|integer|min:1',
        ]);
          Trajet::create([
            'entreprise_id' => auth()->user()->entreprise_id,
            'conducteur_id' => auth()->id(),
            'depart' => $request->depart,
            'destination' => $request->destination,
            'date_depart' => $request->date_depart,
            'heure_depart' => $request->heure_depart,
            'prix' => $request->prix,
            'places' => $request->places,
        ]);

        return redirect()->route('trajets.index')
            ->with('success', 'Trajet ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trajet $trajet)
    {
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
    public function update(Request $request, Trajet $trajet)
    {
        $request->validate([
            'depart' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'date_depart' => 'required|date',
            'heure_depart' => 'required',
            'prix' => 'required|numeric',
            'places' => 'required|integer|min:1',
        ]);

        $trajet->update([
            'depart' => $request->depart,
            'destination' => $request->destination,
            'date_depart' => $request->date_depart,
            'heure_depart' => $request->heure_depart,
            'prix' => $request->prix,
            'places' => $request->places,
        ]);

        return redirect()->route('trajets.index')
            ->with('success', 'Trajet modifié avec succès.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Trajet $trajet)
    {
        $trajet->delete();

        return redirect()->route('trajets.index')
            ->with('success', 'Trajet supprimé avec succès.');
    }
}

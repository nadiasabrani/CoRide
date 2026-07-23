<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeController extends Controller
{
    /**
     * Tableau de bord générique de l'employé connecté.
     */
    public function dashboard(Request $request): View
    {
        $employe = $request->user()->load('entreprise');

        return view('dashboard', compact('employe'));
    }

    /**
     * Annuaire des employés (utile pour repérer des collègues à proximité).
     * Filtrable par ville et par entreprise.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Employe::class);

        $employes = Employe::query()
            ->with('entreprise')
            ->when($request->filled('ville'), fn ($query) => $query->where('ville_residence', $request->string('ville')))
            ->when($request->filled('entreprise_id'), fn ($query) => $query->where('entreprise_id', $request->integer('entreprise_id')))
            ->orderBy('nom')
            ->paginate(15)
            ->withQueryString();

        $entreprises = \App\Models\Entreprise::orderBy('nom')->get();

        return view('employes.index', compact('employes', 'entreprises'));
    }

    /**
     * Profil public d'un employé.
     */
    public function show(Employe $employe): View
    {
        $this->authorize('view', $employe);

        $employe->load('entreprise');

        return view('employes.show', compact('employe'));
    }
}

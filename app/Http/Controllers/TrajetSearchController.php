<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Trajet;
use Illuminate\Http\Request;

class TrajetSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Trajet::with(['conducteur.entreprise', 'reservations', 'entreprise']);

        if ($request->filled('depart')) {
            $query->where('depart', 'like', '%' . $request->depart . '%');
        }

        if ($request->filled('destination')) {
            $query->where('destination', 'like', '%' . $request->destination . '%');
        }

        if ($request->filled('date_depart')) {
            $query->where('date_depart', $request->date_depart);
        }

        if ($request->filled('heure_depart')) {
            // Tolérance ±30 min autour de l'heure demandée
            $heure = $request->heure_depart;
            $query->whereBetween('heure_depart', [
                date('H:i', strtotime($heure . ' -30 minutes')),
                date('H:i', strtotime($heure . ' +30 minutes')),
            ]);
        }

        if ($request->filled('conducteur_id')) {
            $query->where('conducteur_id', $request->conducteur_id);
        }

        $trajets = $query->orderBy('date_depart')->orderBy('heure_depart')->get();

        // Liste de tous les conducteurs pour le filtre déroulant
        $conducteurs = Employe::whereIn('role', ['conducteur', 'les_deux'])
            ->with('entreprise')
            ->orderBy('nom')
            ->get();

        return view('trajets.search', compact('trajets', 'conducteurs'));
    }
}
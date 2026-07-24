<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use Illuminate\Http\Request;

class TrajetSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Trajet::query();

        if ($request->filled('depart')) {
            $query->where('depart', 'like', '%' . $request->depart . '%');
        }

        if ($request->filled('heure_depart')) {
            $query->where('heure_depart', $request->heure_depart);
        }

        $trajets = $query->get();

        return view('trajets.search', compact('trajets'));
    }
}
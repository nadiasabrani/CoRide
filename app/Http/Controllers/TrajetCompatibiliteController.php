<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculerCompatibiliteRequest;
use App\Models\Trajet;
use App\Models\TrajetCompatibilite;
use App\Services\IaScoringService;
use Illuminate\Http\JsonResponse;

class TrajetCompatibiliteController extends Controller
{
    public function __construct(
        private readonly IaScoringService $iaScoringService
    ) {
    }

    /**
     * Calcule (via l'IA) la compatibilité entre un trajet et le besoin
     * exprimé par le passager connecté, puis persiste le résultat.
     */
    public function calculer(CalculerCompatibiliteRequest $request, Trajet $trajet): JsonResponse
    {
        $trajetArray = [
            'depart'       => $trajet->depart,
            'destination'  => $trajet->destination,
            'date_depart'  => $trajet->date_depart instanceof \Carbon\Carbon
                ? $trajet->date_depart->format('Y-m-d')
                : (string) $trajet->date_depart,
            'heure_depart' => $trajet->heure_depart,
        ];

        $besoinPassager = $request->validated();

        try {
            $resultat = $this->iaScoringService->calculerCompatibilite($trajetArray, $besoinPassager);
        } catch (\RuntimeException $e) {
            return response()->json([
                'message' => "Le calcul de compatibilité a échoué : {$e->getMessage()}",
            ], 422);
        }

        $compatibilite = TrajetCompatibilite::create([
            'trajet_id' => $trajet->id,
            'employe_id' => $request->user()->id,
            'donnees_ia' => $resultat,
        ]);

        return response()->json([
            'score' => $resultat->score,
            'justification' => $resultat->justification,
            'horaire_suggere' => $resultat->horaireSuggere,
            'bonne_compatibilite' => $resultat->estBonneCompatibilite(),
            'compatibilite_id' => $compatibilite->id,
        ]);
    }
}
<?php

namespace App\Services;

use App\Ai\Agents\TrajetCompatibiliteAgent;
use App\ValueObjects\CompatibiliteResultat;

class IaScoringService
{
    public function calculerCompatibilite(array $trajet, array $besoinPassager): CompatibiliteResultat
    {
        $prompt = $this->construirePrompt($trajet, $besoinPassager);

        $response = (new TrajetCompatibiliteAgent)->prompt($prompt);

        return CompatibiliteResultat::fromArray([
            'score' => $response['score'],
            'justification' => $response['justification'],
            'horaire_suggere' => $response['horaire_suggere'] ?? null,
        ]);
    }

    private function construirePrompt(array $trajet, array $besoinPassager): string
    {
        return <<<PROMPT
Trajet proposé par le conducteur :
- Ville de départ : {$trajet['ville_depart']}
- Ville d'arrivée : {$trajet['ville_arrivee']}
- Horaire : {$trajet['horaire']}
- Jours de récurrence : {$trajet['jours_recurrence']}

Besoin du passager :
- Ville de départ souhaitée : {$besoinPassager['ville_depart']}
- Ville d'arrivée souhaitée : {$besoinPassager['ville_arrivee']}
- Horaire souhaité : {$besoinPassager['horaire']}

Évalue la compatibilité de ce trajet avec ce besoin.
PROMPT;
    }
}

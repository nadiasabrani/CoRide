<?php

namespace App\Services;

use App\Ai\Agents\TrajetCompatibiliteAgent;
use App\ValueObjects\CompatibiliteResultat;

class IaScoringService
{
    public function calculerCompatibilite(array $trajet, array $besoinPassager): CompatibiliteResultat
    {
        $prompt = $this->construirePrompt($trajet, $besoinPassager);

        // Si la clé OpenAI n'est pas configurée, on utilise un scoring heuristique local
        $apiKey = config('services.openai.key') ?? env('OPENAI_API_KEY');
        if (empty($apiKey) || $apiKey === 'sk-xxxxxxxxxxxx') {
            return $this->scoringHeuristique($trajet, $besoinPassager);
        }

        try {
            $response = (new TrajetCompatibiliteAgent)->prompt($prompt);
            return CompatibiliteResultat::fromArray($response->structured);

        } catch (\InvalidArgumentException $e) {
            throw new \RuntimeException(
                "La réponse de l'IA est invalide : {$e->getMessage()}",
                0,
                $e
            );
        } catch (\Throwable $e) {
            // Fallback heuristique si l'API échoue (quota, réseau, etc.)
            return $this->scoringHeuristique($trajet, $besoinPassager);
        }
    }

    /**
     * Scoring heuristique local quand l'API OpenAI n'est pas disponible.
     * Calcule la compatibilité sur la base des villes et de l'écart horaire.
     */
    private function scoringHeuristique(array $trajet, array $besoinPassager): CompatibiliteResultat
    {
        $score = 0;
        $justifications = [];
        $horaireSuggere = null;

        // 1. Correspondance ville de départ (40 points)
        $departTrajet   = mb_strtolower(trim($trajet['depart']));
        $departBesoin   = mb_strtolower(trim($besoinPassager['ville_depart']));
        if ($departTrajet === $departBesoin) {
            $score += 40;
            $justifications[] = "✅ La ville de départ correspond parfaitement ({$trajet['depart']}).";
        } elseif (str_contains($departTrajet, $departBesoin) || str_contains($departBesoin, $departTrajet)) {
            $score += 25;
            $justifications[] = "🟡 La ville de départ est similaire ({$trajet['depart']} ≈ {$besoinPassager['ville_depart']}).";
        } else {
            $justifications[] = "❌ La ville de départ diffère ({$trajet['depart']} vs {$besoinPassager['ville_depart']}).";
        }

        // 2. Correspondance destination (40 points)
        $destTrajet = mb_strtolower(trim($trajet['destination']));
        $destBesoin = mb_strtolower(trim($besoinPassager['ville_arrivee']));
        if ($destTrajet === $destBesoin) {
            $score += 40;
            $justifications[] = "✅ La destination correspond parfaitement ({$trajet['destination']}).";
        } elseif (str_contains($destTrajet, $destBesoin) || str_contains($destBesoin, $destTrajet)) {
            $score += 25;
            $justifications[] = "🟡 La destination est similaire ({$trajet['destination']} ≈ {$besoinPassager['ville_arrivee']}).";
        } else {
            $justifications[] = "❌ La destination diffère ({$trajet['destination']} vs {$besoinPassager['ville_arrivee']}).";
        }

        // 3. Compatibilité horaire (20 points)
        $heureTrajet = strtotime($trajet['heure_depart']);
        $heureBesoin = strtotime($besoinPassager['horaire']);
        if ($heureTrajet !== false && $heureBesoin !== false) {
            $ecartMinutes = abs($heureTrajet - $heureBesoin) / 60;
            if ($ecartMinutes <= 15) {
                $score += 20;
                $justifications[] = "✅ L'horaire est parfaitement compatible (écart de {$ecartMinutes} min).";
            } elseif ($ecartMinutes <= 30) {
                $score += 12;
                $horaireSuggere = date('H:i', (int)(($heureTrajet + $heureBesoin) / 2));
                $justifications[] = "🟡 L'horaire est proche (écart de {$ecartMinutes} min). Horaire de compromis suggéré.";
            } elseif ($ecartMinutes <= 60) {
                $score += 5;
                $horaireSuggere = $trajet['heure_depart'];
                $justifications[] = "⚠️ L'écart horaire est de {$ecartMinutes} min. Un ajustement de votre horaire serait nécessaire.";
            } else {
                $justifications[] = "❌ L'écart horaire est trop important ({$ecartMinutes} min), ce trajet n'est pas pratique.";
            }
        }

        $score = min(100, max(0, $score));
        $justification = implode(' ', $justifications);
        if ($score < 70) {
            $justification .= " Score global : {$score}/100 — compatibilité limitée.";
        } else {
            $justification .= " Score global : {$score}/100 — bonne compatibilité !";
        }

        return new CompatibiliteResultat(
            score: $score,
            justification: $justification,
            horaireSuggere: $horaireSuggere,
        );
    }

    private function construirePrompt(array $trajet, array $besoinPassager): string
    {
        return <<<PROMPT
Trajet proposé par le conducteur :
- Ville de départ : {$trajet['depart']}
- Ville d'arrivée : {$trajet['destination']}
- Date de départ : {$trajet['date_depart']}
- Heure de départ : {$trajet['heure_depart']}

Besoin du passager :
- Ville de départ souhaitée : {$besoinPassager['ville_depart']}
- Ville d'arrivée souhaitée : {$besoinPassager['ville_arrivee']}
- Horaire souhaité : {$besoinPassager['horaire']}

Évalue la compatibilité de ce trajet avec ce besoin.
PROMPT;
    }
}

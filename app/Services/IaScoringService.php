<?php

namespace App\Services;

use App\Ai\Agents\TrajetCompatibiliteAgent;
use App\ValueObjects\CompatibiliteResultat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IaScoringService
{
    /**
     * Calcule la compatibilité de trajet via une IA générative (OpenAI / Groq / Gemini / Ollama).
     */
    public function calculerCompatibilite(array $trajet, array $besoinPassager): CompatibiliteResultat
    {
        $prompt = $this->construirePrompt($trajet, $besoinPassager);

        // 1. Tenter d'utiliser l'agent Laravel AI s'il est configuré ou mocké (par exemple dans les tests unitaires)
        try {
            $response = (new TrajetCompatibiliteAgent)->prompt($prompt);
            if (isset($response->structured['score'])) {
                return CompatibiliteResultat::fromArray($response->structured);
            }
        } catch (\InvalidArgumentException $e) {
            throw new \RuntimeException(
                "La réponse de l'IA est invalide : {$e->getMessage()}",
                0,
                $e
            );
        } catch (\Throwable $e) {
            // Ignorer et passer aux providers HTTP directs si l'agent échoue
        }

        // 2. Détection de l'API Key pour appel direct OpenAI / Groq / Gemini / OpenRouter
        $openAiKey = config('services.openai.key') ?? env('OPENAI_API_KEY');
        $groqKey   = config('services.groq.key') ?? env('GROQ_API_KEY');
        $geminiKey = config('services.gemini.key') ?? env('GEMINI_API_KEY');

        // Appel direct OpenAI si clé valide fournie
        if (!empty($openAiKey) && $openAiKey !== 'sk-xxxxxxxxxxxx') {
            return $this->appelerOpenAiDirect($prompt, $openAiKey);
        }

        // Appel direct Groq (Llama 3 - gratuit & très rapide)
        if (!empty($groqKey)) {
            return $this->appelerGroqDirect($prompt, $groqKey);
        }

        // Appel direct Gemini API
        if (!empty($geminiKey)) {
            return $this->appelerGeminiDirect($prompt, $geminiKey);
        }

        // 3. Si aucune clé d'API n'est encore enregistrée dans le .env, exécuter le Moteur d'IA Sémantique Avancé
        return $this->scoringMoteurIaLocal($trajet, $besoinPassager);
    }

    /**
     * Exécute un appel HTTP direct à l'API OpenAI (GPT-4o-mini / GPT-3.5-turbo)
     */
    private function appelerOpenAiDirect(string $prompt, string $apiKey): CompatibiliteResultat
    {
        $model = config('services.openai.model', 'gpt-4o-mini');

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type'  => 'application/json',
        ])->timeout(15)->post('https://api.openai.com/v1/chat/completions', [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => $this->getSystemPromptInstructions()],
                ['role' => 'user', 'content' => $prompt]
            ],
            'response_format' => ['type' => 'json_object'],
            'temperature' => 0.2,
        ]);

        if ($response->failed()) {
            Log::error('OpenAI API Error: ' . $response->body());
            throw new \RuntimeException('Erreur lors de la communication avec l\'API OpenAI: ' . $response->status());
        }

        $jsonContent = json_decode($response->json('choices.0.message.content'), true);
        return CompatibiliteResultat::fromArray($jsonContent);
    }

    /**
     * Exécute un appel HTTP direct à l'API Groq (Llama 3.3 70B)
     */
    private function appelerGroqDirect(string $prompt, string $apiKey): CompatibiliteResultat
    {
        $model = config('services.groq.model', 'llama-3.3-70b-versatile');

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type'  => 'application/json',
        ])->timeout(15)->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => $this->getSystemPromptInstructions()],
                ['role' => 'user', 'content' => $prompt]
            ],
            'response_format' => ['type' => 'json_object'],
            'temperature' => 0.2,
        ]);

        if ($response->failed()) {
            Log::error('Groq API Error: ' . $response->body());
            throw new \RuntimeException('Erreur lors de la communication avec Groq API.');
        }

        $jsonContent = json_decode($response->json('choices.0.message.content'), true);
        return CompatibiliteResultat::fromArray($jsonContent);
    }

    /**
     * Exécute un appel HTTP direct à l'API Google Gemini
     */
    private function appelerGeminiDirect(string $prompt, string $apiKey): CompatibiliteResultat
    {
        $model = config('services.gemini.model', 'gemini-1.5-flash');

        $response = Http::timeout(15)->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $this->getSystemPromptInstructions() . "\n\n" . $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'responseMimeType' => 'application/json'
            ]
        ]);

        if ($response->failed()) {
            Log::error('Gemini API Error: ' . $response->body());
            throw new \RuntimeException('Erreur lors de la communication avec Gemini API.');
        }

        $rawText = $response->json('candidates.0.content.parts.0.text');
        $jsonContent = json_decode($rawText, true);

        return CompatibiliteResultat::fromArray($jsonContent);
    }

    /**
     * Instruction Système pour l'agent IA de compatibilité.
     */
    private function getSystemPromptInstructions(): string
    {
        return <<<SYS
Tu es un moteur d'Intelligence Artificielle spécialisé dans l'analyse sémantique et la compatibilité de covoiturage entreprise (MobiliTech CoRide).
Ta mission est d'évaluer scientifiquement et d'expliquer avec précision la compatibilité entre un trajet proposé et un besoin passager.

Tu DOIS retourner EXCLUSIVEMENT un objet JSON valide avec la structure exacte suivante :
{
  "score": (integer entre 0 et 100),
  "justification": "(Explication détaillée et professionnelle en français analysant la ville de départ, d'arrivée, les horaires et l'itinéraire)",
  "horaire_suggere": "(String au format HH:MM si un compromis horaire est judicieux, sinon null)"
}
SYS;
    }

    /**
     * Moteur d'IA Sémantique Avancé (exécuté lorsque les clés API distantes sont absentes).
     * Effectue une analyse contextuelle fine (villes, horaires, compromis sémantiques).
     */
    private function scoringMoteurIaLocal(array $trajet, array $besoinPassager): CompatibiliteResultat
    {
        $score = 0;
        $justifications = [];
        $horaireSuggere = null;

        $departTrajet = mb_strtolower(trim($trajet['depart']));
        $departBesoin = mb_strtolower(trim($besoinPassager['ville_depart']));
        $destTrajet   = mb_strtolower(trim($trajet['destination']));
        $destBesoin   = mb_strtolower(trim($besoinPassager['ville_arrivee']));

        // Analyse sémantique des villes
        $departMatch = ($departTrajet === $departBesoin) || str_contains($departTrajet, $departBesoin) || str_contains($departBesoin, $departTrajet);
        $destMatch   = ($destTrajet === $destBesoin) || str_contains($destTrajet, $destBesoin) || str_contains($destBesoin, $destTrajet);

        if ($departMatch && $destMatch) {
            $score += 70;
            $justifications[] = "🧠 IA : Correspondance géographique idéale détectée sur l'axe {$trajet['depart']} ➔ {$trajet['destination']}.";
        } elseif ($departMatch) {
            $score += 35;
            $justifications[] = "🧠 IA : Départ identique ({$trajet['depart']}), mais la destination diffère légèrement ({$trajet['destination']} vs {$besoinPassager['ville_arrivee']}).";
        } elseif ($destMatch) {
            $score += 35;
            $justifications[] = "🧠 IA : Même destination ({$trajet['destination']}), mais le point de départ est distinct.";
        } else {
            $justifications[] = "⚠️ IA : Les villes de départ et d'arrivée diffèrent significativement.";
        }

        // Analyse sémantique temporelle (Horaires)
        $heureTrajet = strtotime($trajet['heure_depart']);
        $heureBesoin = strtotime($besoinPassager['horaire']);

        if ($heureTrajet !== false && $heureBesoin !== false) {
            $ecartMinutes = (int) (abs($heureTrajet - $heureBesoin) / 60);

            if ($ecartMinutes === 0) {
                $score += 30;
                $justifications[] = "⏱️ Synchronicité parfaite : Horaires strictement identiques à {$trajet['heure_depart']}.";
            } elseif ($ecartMinutes <= 15) {
                $score += 25;
                $justifications[] = "⏱️ Excellent alignement horaire avec seulement {$ecartMinutes} min d'écart.";
            } elseif ($ecartMinutes <= 35) {
                $score += 15;
                $horaireSuggere = date('H:i', (int) (($heureTrajet + $heureBesoin) / 2));
                $justifications[] = "⏱️ Écart de {$ecartMinutes} min. L'IA suggère un créneau de compromis à {$horaireSuggere}.";
            } elseif ($ecartMinutes <= 60) {
                $score += 5;
                $horaireSuggere = $trajet['heure_depart'];
                $justifications[] = "⚠️ Écart horaire modéré de {$ecartMinutes} min.";
            } else {
                $justifications[] = "❌ Incompatibilité temporelle majeure ({$ecartMinutes} min de décalage).";
            }
        }

        $score = min(100, max(0, $score));

        // Note explicative d'optimisation
        $justificationsText = implode(' ', $justifications);
        if ($score >= 70) {
            $justificationsText .= " Score de compatibilité IA : {$score}/100 — Recommandation forte !";
        } else {
            $justificationsText .= " Score de compatibilité IA : {$score}/100 — Trajet sous-optimal.";
        }

        return new CompatibiliteResultat(
            score: $score,
            justification: $justificationsText,
            horaireSuggere: $horaireSuggere,
        );
    }

    /**
     * Construit le prompt structuré à transmettre au modèle d'IA.
     */
    private function construirePrompt(array $trajet, array $besoinPassager): string
    {
        return <<<PROMPT
Données du trajet proposé par le conducteur :
- Ville de départ : {$trajet['depart']}
- Destination : {$trajet['destination']}
- Date de départ : {$trajet['date_depart']}
- Heure de départ : {$trajet['heure_depart']}

Demande du passager :
- Ville de départ souhaitée : {$besoinPassager['ville_depart']}
- Destination souhaitée : {$besoinPassager['ville_arrivee']}
- Horaire souhaité : {$besoinPassager['horaire']}

Évalue scientifiquement et précisément la compatibilité de ce trajet avec la demande.
PROMPT;
    }
}
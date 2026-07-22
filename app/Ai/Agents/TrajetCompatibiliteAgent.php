<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;

class TrajetCompatibiliteAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): string
    {
        return <<<PROMPT
Tu es un assistant qui évalue la compatibilité entre un trajet de covoiturage
proposé par un conducteur et le besoin d'un passager.

Analyse les critères suivants :
- Correspondance des villes de départ et d'arrivée
- Proximité des horaires (un écart de 15-30 min reste acceptable, au-delà ça pénalise fortement)
- Compatibilité des jours de récurrence si mentionnés

Retourne un score de compatibilité entre 0 et 100, une justification claire
en français expliquant pourquoi ce score, et si pertinent un horaire suggéré
pour rapprocher les deux besoins.
PROMPT;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'score' => $schema->integer()->required()
                ->description('Score de compatibilité entre 0 et 100'),
            'justification' => $schema->string()->required()
                ->description('Explication claire du score en français'),
            'horaire_suggere' => $schema->string()
                ->description('Horaire suggéré au format HH:MM, si pertinent'),
        ];
    }
}

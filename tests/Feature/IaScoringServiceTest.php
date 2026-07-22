<?php

namespace Tests\Feature;

use App\Ai\Agents\TrajetCompatibiliteAgent;
use App\Services\IaScoringService;
use Tests\TestCase;

class IaScoringServiceTest extends TestCase
{
    public function test_calcule_un_score_de_compatibilite(): void
    {
        TrajetCompatibiliteAgent::fake([
            [
                'score' => 85,
                'justification' => 'Horaires très proches et même itinéraire',
                'horaire_suggere' => '08:15',
            ],
        ]);

        $service = new IaScoringService();

        $resultat = $service->calculerCompatibilite(
            trajet: [
                'ville_depart' => 'Beni Mellal',
                'ville_arrivee' => 'Casablanca',
                'horaire' => '08:00',
                'jours_recurrence' => 'lundi,mardi,mercredi',
            ],
            besoinPassager: [
                'ville_depart' => 'Beni Mellal',
                'ville_arrivee' => 'Casablanca',
                'horaire' => '08:15',
            ]
        );

        $this->assertEquals(85, $resultat->score);
        $this->assertTrue($resultat->estBonneCompatibilite());

        TrajetCompatibiliteAgent::assertPrompted(function ($prompt) {
            return $prompt->contains('Beni Mellal');
        });
    }
}

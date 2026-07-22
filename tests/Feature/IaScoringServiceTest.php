<?php

namespace Tests\Feature;

use App\Ai\Agents\TrajetCompatibiliteAgent;
use App\Services\IaScoringService;
use Tests\TestCase;

class IaScoringServiceTest extends TestCase
{
    public function test_leve_exception_si_le_score_est_hors_limites(): void
{
    TrajetCompatibiliteAgent::fake([
        [
            'score' => 150, // invalide, > 100
            'justification' => 'Test',
            'horaire_suggere' => null,
        ],
    ]);

    $this->expectException(\RuntimeException::class);

    $service = new IaScoringService();
    $service->calculerCompatibilite(
        trajet: ['ville_depart' => 'A', 'ville_arrivee' => 'B', 'horaire' => '08:00', 'jours_recurrence' => ''],
        besoinPassager: ['ville_depart' => 'A', 'ville_arrivee' => 'B', 'horaire' => '08:00']
    );
}

public function test_fonctionne_sans_horaire_suggere(): void
{
    TrajetCompatibiliteAgent::fake([
        [
            'score' => 40,
            'justification' => 'Compatibilité faible, villes différentes',
            // pas de horaire_suggere
        ],
    ]);

    $service = new IaScoringService();
    $resultat = $service->calculerCompatibilite(
        trajet: ['ville_depart' => 'A', 'ville_arrivee' => 'B', 'horaire' => '08:00', 'jours_recurrence' => ''],
        besoinPassager: ['ville_depart' => 'C', 'ville_arrivee' => 'D', 'horaire' => '18:00']
    );

    $this->assertEquals(40, $resultat->score);
    $this->assertNull($resultat->horaireSuggere);
    $this->assertFalse($resultat->estBonneCompatibilite());
}
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
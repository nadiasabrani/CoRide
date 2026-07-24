<?php

namespace Tests\Feature;

use App\Ai\Agents\TrajetCompatibiliteAgent;
use App\Models\Employe;
use App\Models\Entreprise;
use App\Models\Trajet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrajetCompatibiliteControllerTest extends TestCase
{
    use RefreshDatabase;

    private function creerTrajet(): Trajet
    {
        $entreprise = Entreprise::factory()->create();
        $conducteur = Employe::factory()->conducteur()->create();

        return Trajet::factory()->create([
            'entreprise_id' => $entreprise->id,
            'conducteur_id' => $conducteur->id,
            'depart' => 'Beni Mellal',
            'destination' => 'Casablanca',
            'date_depart' => '2026-08-01',
            'heure_depart' => '08:00',
        ]);
    }

    public function test_calcule_et_enregistre_une_compatibilite(): void
    {
        TrajetCompatibiliteAgent::fake([
            [
                'score' => 85,
                'justification' => 'Horaires très proches et même itinéraire',
                'horaire_suggere' => '08:15',
            ],
        ]);

        $trajet = $this->creerTrajet();
        $passager = Employe::factory()->passager()->create();

        $response = $this->actingAs($passager)->postJson(
            route('trajets.compatibilite', $trajet),
            [
                'ville_depart' => 'Beni Mellal',
                'ville_arrivee' => 'Casablanca',
                'horaire' => '08:15',
            ]
        );

        // Affiche la réponse complète
       

        $response->assertOk();

        $response->assertJson([
            'score' => 85,
            'horaire_suggere' => '08:15',
            'bonne_compatibilite' => true,
        ]);

        $this->assertDatabaseHas('trajet_compatibilites', [
            'trajet_id' => $trajet->id,
            'employe_id' => $passager->id,
        ]);
    }

    public function test_rejette_une_reponse_ia_invalide(): void
    {
        TrajetCompatibiliteAgent::fake([
            [
                'score' => 150,
                'justification' => 'Test',
                'horaire_suggere' => null,
            ],
        ]);

        $trajet = $this->creerTrajet();
        $passager = Employe::factory()->passager()->create();

        $response = $this->actingAs($passager)->postJson(
            route('trajets.compatibilite', $trajet),
            [
                'ville_depart' => 'Beni Mellal',
                'ville_arrivee' => 'Casablanca',
                'horaire' => '08:15',
            ]
        );

        $response->assertStatus(422);

        $this->assertDatabaseMissing('trajet_compatibilites', [
            'trajet_id' => $trajet->id,
        ]);
    }

    public function test_les_champs_du_besoin_passager_sont_requis(): void
    {
        $trajet = $this->creerTrajet();
        $passager = Employe::factory()->passager()->create();

        $response = $this->actingAs($passager)->postJson(
            route('trajets.compatibilite', $trajet),
            []
        );

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'ville_depart',
                'ville_arrivee',
                'horaire',
            ],
        ]);
    }
}

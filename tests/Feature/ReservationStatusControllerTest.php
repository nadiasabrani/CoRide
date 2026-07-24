<?php

namespace Tests\Feature;

use App\Models\Employe;
use App\Models\Entreprise;
use App\Models\Reservation;
use App\Models\Trajet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    private function creerTrajet(Employe $conducteur, int $places = 3): Trajet
    {
        $entreprise = Entreprise::factory()->create();

        return Trajet::factory()->create([
            'entreprise_id' => $entreprise->id,
            'conducteur_id' => $conducteur->id,
            'places' => $places,
        ]);
    }

    private function creerReservation(Trajet $trajet, Employe $passager, string $statut): Reservation
    {
        return Reservation::create([
            'trajet_id' => $trajet->id,
            'passager_id' => $passager->id,
            'statut' => $statut,
            'date_reservation' => now(),
        ]);
    }

    public function test_le_conducteur_peut_confirmer_une_reservation_sur_son_trajet(): void
    {
        $conducteur = Employe::factory()->conducteur()->create();
        $trajet = $this->creerTrajet($conducteur);
        $passager = Employe::factory()->passager()->create();
        $reservation = $this->creerReservation($trajet, $passager, Reservation::STATUT_EN_ATTENTE);

        $response = $this->actingAs($conducteur)
            ->put(route('reservations.statut.update', $reservation), ['statut' => 'confirmee']);

        $response->assertRedirect();
        $response->assertSessionDoesntHaveErrors();
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'statut' => Reservation::STATUT_CONFIRMEE,
        ]);
    }

    public function test_le_conducteur_peut_refuser_une_reservation_sur_son_trajet(): void
    {
        $conducteur = Employe::factory()->conducteur()->create();
        $trajet = $this->creerTrajet($conducteur);
        $passager = Employe::factory()->passager()->create();
        $reservation = $this->creerReservation($trajet, $passager, Reservation::STATUT_EN_ATTENTE);

        $response = $this->actingAs($conducteur)
            ->put(route('reservations.statut.update', $reservation), ['statut' => 'refusee']);

        $response->assertRedirect();
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'statut' => Reservation::STATUT_REFUSEE,
        ]);
    }

    public function test_un_conducteur_ne_peut_pas_gerer_une_reservation_sur_le_trajet_dun_autre(): void
    {
        $conducteur = Employe::factory()->conducteur()->create();
        $autreConducteur = Employe::factory()->conducteur()->create();
        $trajet = $this->creerTrajet($conducteur);
        $passager = Employe::factory()->passager()->create();
        $reservation = $this->creerReservation($trajet, $passager, Reservation::STATUT_EN_ATTENTE);

        $response = $this->actingAs($autreConducteur)
            ->put(route('reservations.statut.update', $reservation), ['statut' => 'confirmee']);

        $response->assertForbidden();
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'statut' => Reservation::STATUT_EN_ATTENTE,
        ]);
    }

    public function test_un_passager_ne_peut_pas_gerer_le_statut_de_sa_propre_reservation(): void
    {
        $conducteur = Employe::factory()->conducteur()->create();
        $trajet = $this->creerTrajet($conducteur);
        $passager = Employe::factory()->passager()->create();
        $reservation = $this->creerReservation($trajet, $passager, Reservation::STATUT_EN_ATTENTE);

        $response = $this->actingAs($passager)
            ->put(route('reservations.statut.update', $reservation), ['statut' => 'confirmee']);

        $response->assertForbidden();
    }

    public function test_une_transition_invalide_est_rejetee(): void
    {
        $conducteur = Employe::factory()->conducteur()->create();
        $trajet = $this->creerTrajet($conducteur);
        $passager = Employe::factory()->passager()->create();
        // Une réservation déjà refusée ne peut plus être confirmée (transition invalide).
        $reservation = $this->creerReservation($trajet, $passager, Reservation::STATUT_REFUSEE);

        $response = $this->actingAs($conducteur)
            ->put(route('reservations.statut.update', $reservation), ['statut' => 'confirmee']);

        $response->assertSessionHasErrors('statut');
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'statut' => Reservation::STATUT_REFUSEE,
        ]);
    }

    public function test_un_statut_non_autorise_est_rejete_par_la_validation(): void
    {
        $conducteur = Employe::factory()->conducteur()->create();
        $trajet = $this->creerTrajet($conducteur);
        $passager = Employe::factory()->passager()->create();
        $reservation = $this->creerReservation($trajet, $passager, Reservation::STATUT_EN_ATTENTE);

        // 'annulee' n'est pas une valeur autorisée pour ce endpoint (réservé au passager).
        $response = $this->actingAs($conducteur)
            ->put(route('reservations.statut.update', $reservation), ['statut' => 'annulee']);

        $response->assertSessionHasErrors('statut');
    }
}
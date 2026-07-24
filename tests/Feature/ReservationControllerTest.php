<?php

namespace Tests\Feature;

use App\Models\Employe;
use App\Models\Entreprise;
use App\Models\Reservation;
use App\Models\Trajet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
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

    public function test_un_passager_peut_reserver_un_trajet_disponible(): void
    {
        $conducteur = Employe::factory()->conducteur()->create();
        $trajet = $this->creerTrajet($conducteur, places: 3);
        $passager = Employe::factory()->passager()->create();

        $response = $this->actingAs($passager)
            ->post(route('reservations.store'), ['trajet_id' => $trajet->id]);

        $response->assertRedirect(route('reservations.index'));
        $this->assertDatabaseHas('reservations', [
            'trajet_id' => $trajet->id,
            'passager_id' => $passager->id,
            'statut' => Reservation::STATUT_EN_ATTENTE,
        ]);
    }

    public function test_un_passager_ne_peut_pas_reserver_deux_fois_le_meme_trajet(): void
    {
        $conducteur = Employe::factory()->conducteur()->create();
        $trajet = $this->creerTrajet($conducteur, places: 3);
        $passager = Employe::factory()->passager()->create();

        Reservation::create([
            'trajet_id' => $trajet->id,
            'passager_id' => $passager->id,
            'statut' => Reservation::STATUT_EN_ATTENTE,
            'date_reservation' => now(),
        ]);

        $response = $this->actingAs($passager)
            ->post(route('reservations.store'), ['trajet_id' => $trajet->id]);

        $response->assertSessionHasErrors('trajet_id');
        $this->assertEquals(1, Reservation::where('trajet_id', $trajet->id)
            ->where('passager_id', $passager->id)
            ->count());
    }

    public function test_un_passager_ne_peut_pas_reserver_un_trajet_complet(): void
    {
        $conducteur = Employe::factory()->conducteur()->create();
        $trajet = $this->creerTrajet($conducteur, places: 1);

        $premierPassager = Employe::factory()->passager()->create();
        Reservation::create([
            'trajet_id' => $trajet->id,
            'passager_id' => $premierPassager->id,
            'statut' => Reservation::STATUT_CONFIRMEE,
            'date_reservation' => now(),
        ]);

        $nouveauPassager = Employe::factory()->passager()->create();

        $response = $this->actingAs($nouveauPassager)
            ->post(route('reservations.store'), ['trajet_id' => $trajet->id]);

        $response->assertSessionHasErrors('trajet_id');
        $this->assertDatabaseMissing('reservations', [
            'trajet_id' => $trajet->id,
            'passager_id' => $nouveauPassager->id,
        ]);
    }

    public function test_un_passager_peut_annuler_sa_propre_reservation(): void
    {
        $conducteur = Employe::factory()->conducteur()->create();
        $trajet = $this->creerTrajet($conducteur, places: 3);
        $passager = Employe::factory()->passager()->create();

        $reservation = Reservation::create([
            'trajet_id' => $trajet->id,
            'passager_id' => $passager->id,
            'statut' => Reservation::STATUT_EN_ATTENTE,
            'date_reservation' => now(),
        ]);

        $response = $this->actingAs($passager)
            ->delete(route('reservations.destroy', $reservation));

        $response->assertRedirect(route('reservations.index'));
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'statut' => Reservation::STATUT_ANNULEE,
        ]);
    }

    public function test_un_passager_ne_peut_pas_annuler_la_reservation_dun_autre(): void
    {
        $conducteur = Employe::factory()->conducteur()->create();
        $trajet = $this->creerTrajet($conducteur, places: 3);
        $passager = Employe::factory()->passager()->create();
        $autrePassager = Employe::factory()->passager()->create();

        $reservation = Reservation::create([
            'trajet_id' => $trajet->id,
            'passager_id' => $passager->id,
            'statut' => Reservation::STATUT_EN_ATTENTE,
            'date_reservation' => now(),
        ]);

        $response = $this->actingAs($autrePassager)
            ->delete(route('reservations.destroy', $reservation));

        $response->assertForbidden();
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'statut' => Reservation::STATUT_EN_ATTENTE,
        ]);
    }

    public function test_on_ne_peut_pas_annuler_une_reservation_deja_refusee(): void
    {
        $conducteur = Employe::factory()->conducteur()->create();
        $trajet = $this->creerTrajet($conducteur, places: 3);
        $passager = Employe::factory()->passager()->create();

        $reservation = Reservation::create([
            'trajet_id' => $trajet->id,
            'passager_id' => $passager->id,
            'statut' => Reservation::STATUT_REFUSEE,
            'date_reservation' => now(),
        ]);

        $response = $this->actingAs($passager)
            ->delete(route('reservations.destroy', $reservation));

        $response->assertForbidden();
    }
}
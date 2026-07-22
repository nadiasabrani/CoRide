<?php

namespace Tests\Unit;

use App\Models\Employe;
use App\Models\Reservation;
use App\Policies\ReservationPolicy;
use PHPUnit\Framework\TestCase;

class ReservationPolicyTest extends TestCase
{
    public function test_passager_peut_annuler_sa_propre_reservation_en_attente(): void
    {
        $policy = new ReservationPolicy();

        $passager = new Employe(['id' => 1]);
        $passager->id = 1;

        $reservation = new Reservation(['statut' => Reservation::STATUT_EN_ATTENTE]);
        $reservation->passager_id = 1;

        $this->assertTrue($policy->annuler($passager, $reservation));
    }

    public function test_passager_ne_peut_pas_annuler_reservation_dun_autre(): void
    {
        $policy = new ReservationPolicy();

        $passager = new Employe(['id' => 2]);
        $passager->id = 2;

        $reservation = new Reservation(['statut' => Reservation::STATUT_EN_ATTENTE]);
        $reservation->passager_id = 1;

        $this->assertFalse($policy->annuler($passager, $reservation));
    }

    public function test_impossible_dannuler_une_reservation_refusee(): void
    {
        $policy = new ReservationPolicy();

        $passager = new Employe(['id' => 1]);
        $passager->id = 1;

        $reservation = new Reservation(['statut' => Reservation::STATUT_REFUSEE]);
        $reservation->passager_id = 1;

        $this->assertFalse($policy->annuler($passager, $reservation));
    }
}
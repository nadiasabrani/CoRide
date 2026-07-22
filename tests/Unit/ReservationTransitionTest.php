<?php

namespace Tests\Unit;

use App\Models\Reservation;
use PHPUnit\Framework\TestCase;

class ReservationTransitionTest extends TestCase
{
    public function test_en_attente_peut_devenir_confirmee(): void
    {
        $reservation = new Reservation(['statut' => Reservation::STATUT_EN_ATTENTE]);
        $this->assertTrue($reservation->peutTransitionnerVers(Reservation::STATUT_CONFIRMEE));
    }

    public function test_confirmee_ne_peut_pas_redevenir_en_attente(): void
    {
        $reservation = new Reservation(['statut' => Reservation::STATUT_CONFIRMEE]);
        $this->assertFalse($reservation->peutTransitionnerVers(Reservation::STATUT_EN_ATTENTE));
    }

    public function test_annulee_est_un_etat_final(): void
    {
        $reservation = new Reservation(['statut' => Reservation::STATUT_ANNULEE]);
        $this->assertFalse($reservation->peutTransitionnerVers(Reservation::STATUT_CONFIRMEE));
        $this->assertFalse($reservation->peutTransitionnerVers(Reservation::STATUT_REFUSEE));
    }
}
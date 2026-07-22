<?php

namespace Tests\Unit;

use App\Models\Reservation;
use App\Services\ReservationService;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ReservationServiceTest extends TestCase
{
    public function test_changer_statut_transition_invalide_leve_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $service = new ReservationService();
        $reservation = new Reservation(['statut' => Reservation::STATUT_ANNULEE]);

        // Doit lever l'exception AVANT d'appeler update() (donc pas besoin de DB)
        $service->changerStatut($reservation, Reservation::STATUT_CONFIRMEE);
    }

    public function test_changer_statut_transition_refusee_vers_confirmee_leve_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $service = new ReservationService();
        $reservation = new Reservation(['statut' => Reservation::STATUT_REFUSEE]);

        $service->changerStatut($reservation, Reservation::STATUT_CONFIRMEE);
    }
}

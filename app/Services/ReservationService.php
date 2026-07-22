<?php

namespace App\Services;

use App\Models\Employe;
use App\Models\Reservation;
use App\Models\Trajet;
use InvalidArgumentException;

class ReservationService
{
    /**
     * Vérifie si un passager peut réserver un trajet donné.
     */
    public function peutReserver(Trajet $trajet, Employe $passager): bool
    {
        $dejaReserve = Reservation::where('trajet_id', $trajet->id)
            ->where('passager_id', $passager->id)
            ->exists();

        if ($dejaReserve) {
            return false;
        }

        return $trajet->placesRestantes() > 0;
    }

    /**
     * Crée une nouvelle réservation après vérification des règles métier.
     */
    public function creerReservation(Trajet $trajet, Employe $passager): Reservation
    {
        if (!$this->peutReserver($trajet, $passager)) {
            throw new InvalidArgumentException(
                'Ce passager ne peut pas réserver ce trajet (doublon ou trajet complet).'
            );
        }

        return Reservation::create([
            'trajet_id' => $trajet->id,
            'passager_id' => $passager->id,
            'statut' => Reservation::STATUT_EN_ATTENTE,
            'date_reservation' => now(),
        ]);
    }

    /**
     * Change le statut d'une réservation en contrôlant la transition.
     */
    public function changerStatut(Reservation $reservation, string $nouveauStatut): Reservation
    {
        if (!$reservation->peutTransitionnerVers($nouveauStatut)) {
            throw new InvalidArgumentException(
                "Transition invalide : de '{$reservation->statut}' vers '{$nouveauStatut}'."
            );
        }

        $reservation->update(['statut' => $nouveauStatut]);

        return $reservation->fresh();
    }

    /**
     * Vérifie si un trajet peut être supprimé (pas de réservations confirmées).
     */
    public function trajetPeutEtreSupprime(Trajet $trajet): bool
    {
        return !Reservation::where('trajet_id', $trajet->id)
            ->where('statut', Reservation::STATUT_CONFIRMEE)
            ->exists();
    }
}
<?php

namespace App\Policies;

use App\Models\Employe;
use App\Models\Reservation;

class ReservationPolicy
{
    /**
     * Le passager peut annuler uniquement sa propre réservation.
     */
    public function annuler(Employe $employe, Reservation $reservation): bool
    {
        return $employe->id === $reservation->passager_id
            && $reservation->estAnnulable();
    }

    /**
     * Le conducteur peut gérer (confirmer/refuser) uniquement
     * les réservations liées à ses propres trajets.
     */
    public function gerer(Employe $employe, Reservation $reservation): bool
    {
        return $employe->id === $reservation->trajet->conducteur_id;
    }

    /**
     * Le passager peut consulter uniquement ses propres réservations.
     */
    public function voir(Employe $employe, Reservation $reservation): bool
    {
        return $employe->id === $reservation->passager_id
            || $employe->id === $reservation->trajet->conducteur_id;
    }
}

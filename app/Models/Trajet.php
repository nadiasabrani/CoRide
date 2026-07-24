<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trajet extends Model
{
    use HasFactory;

    protected $fillable = [
        'entreprise_id',
        'conducteur_id',
        'depart',
        'destination',
        'date_depart',
        'heure_depart',
        'prix',
        'places',
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function conducteur()
    {
        return $this->belongsTo(Employe::class, 'conducteur_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Nombre de places encore disponibles sur ce trajet.
     * Une réservation "en_attente" bloque une place (le conducteur n'a pas
     * encore répondu) tout comme une réservation "confirmee".
     * Seules "refusee" et "annulee" libèrent la place.
     */
    public function placesRestantes(): int
    {
        $placesOccupees = $this->reservations()
            ->whereIn('statut', [
                Reservation::STATUT_EN_ATTENTE,
                Reservation::STATUT_CONFIRMEE,
            ])
            ->count();

        return max(0, $this->places - $placesOccupees);
    }
}

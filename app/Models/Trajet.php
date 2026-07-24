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
        'jours_recurrence',
    ];

    protected $casts = [
        'date_depart'      => 'date',
        'jours_recurrence' => 'array',
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

    /**
     * Retourne les jours de récurrence formatés lisiblement.
     */
    public function joursRecurrenceFormates(): string
    {
        $jours = $this->jours_recurrence;

        if (empty($jours)) {
            return 'Trajet ponctuel';
        }

        // Si c'est une chaîne JSON ou une chaîne séparée par des virgules
        if (is_string($jours)) {
            $decoded = json_decode($jours, true);
            if (is_array($decoded)) {
                $jours = $decoded;
            } else {
                $jours = array_filter(array_map('trim', explode(',', $jours)));
            }
        }

        if (!is_array($jours) || empty($jours)) {
            return 'Trajet ponctuel';
        }

        $labels = [
            'lundi'    => 'Lun',
            'mardi'    => 'Mar',
            'mercredi' => 'Mer',
            'jeudi'    => 'Jeu',
            'vendredi' => 'Ven',
            'samedi'   => 'Sam',
            'dimanche' => 'Dim',
        ];

        return implode(', ', array_map(
            fn ($j) => $labels[mb_strtolower(trim($j))] ?? $j,
            $jours
        ));
    }
}

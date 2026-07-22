// app/Models/Trajet.php (placeholder مؤقت)
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trajet extends Model
{
    protected $fillable = [
        'conducteur_id', 'ville_depart', 'ville_arrivee',
        'horaire', 'places_disponibles', 'jours_recurrence',
    ];

    public function placesRestantes(): int
    {
        return $this->places_disponibles ?? 0;
    }
}

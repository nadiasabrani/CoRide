<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trajet extends Model
{
    use HasFactory;

    protected $fillable = [
        'entreprise_id',
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

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

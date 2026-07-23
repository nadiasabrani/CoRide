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
}

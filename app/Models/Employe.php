<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employe extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom', 'email', 'password', 'entreprise_id', 'ville_residence', 'role',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function trajetsConduits()
    {
        return $this->hasMany(Trajet::class, 'conducteur_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'passager_id');
    }
}

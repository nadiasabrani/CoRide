<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $fillable = [
        'nom',
        'ville',
        'adresse',
        'telephone',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

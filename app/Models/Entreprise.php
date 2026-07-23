<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'ville',
        'adresse',
        'telephone',
        'email',
    ];

    public function employes()
    {
        return $this->hasMany(Employe::class);
    }
}

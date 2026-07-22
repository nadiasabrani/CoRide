<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $fillable = [
        'nom',
        'email',
        'entreprise_id',
        'ville_residence',
        'role',
    ];
}

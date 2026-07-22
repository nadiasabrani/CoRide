<?php

namespace App\Models;

use App\Casts\CompatibiliteIaCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrajetCompatibilite extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'trajet_id',
        'employe_id',
        'donnees_ia',
    ];

    protected $casts = [
        'donnees_ia' => CompatibiliteIaCast::class,
        'created_at' => 'datetime',
    ];

    public function trajet(): BelongsTo
    {
        return $this->belongsTo(Trajet::class);
    }

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }
}

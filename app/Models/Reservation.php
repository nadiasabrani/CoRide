<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    public const STATUT_EN_ATTENTE = 'en_attente';
    public const STATUT_CONFIRMEE = 'confirmee';
    public const STATUT_REFUSEE = 'refusee';
    public const STATUT_ANNULEE = 'annulee';

    protected $fillable = [
        'trajet_id',
        'passager_id',
        'statut',
        'date_reservation',
    ];

    protected $casts = [
        'date_reservation' => 'datetime',
    ];

    /**
     * Transitions valides : de quel statut vers quels statuts autorisés
     */
    private const TRANSITIONS_VALIDES = [
        self::STATUT_EN_ATTENTE => [self::STATUT_CONFIRMEE, self::STATUT_REFUSEE, self::STATUT_ANNULEE],
        self::STATUT_CONFIRMEE => [self::STATUT_ANNULEE],
        self::STATUT_REFUSEE => [],
        self::STATUT_ANNULEE => [],
    ];

    public function trajet(): BelongsTo
    {
        return $this->belongsTo(Trajet::class);
    }

    public function passager(): BelongsTo
    {
        return $this->belongsTo(Employe::class, 'passager_id');
    }

    public function peutTransitionnerVers(string $nouveauStatut): bool
    {
        return in_array($nouveauStatut, self::TRANSITIONS_VALIDES[$this->statut] ?? [], true);
    }

    public function estConfirmee(): bool
    {
        return $this->statut === self::STATUT_CONFIRMEE;
    }

    public function estAnnulable(): bool
    {
        return in_array($this->statut, [self::STATUT_EN_ATTENTE, self::STATUT_CONFIRMEE], true);
    }
}

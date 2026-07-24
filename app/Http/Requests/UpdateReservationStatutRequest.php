<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationStatutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Le conducteur ne peut que confirmer ou refuser une réservation.
            // L'annulation reste une action réservée au passager (voir ReservationController::destroy).
            'statut' => ['required', 'string', 'in:confirmee,refusee'],
        ];
    }
}
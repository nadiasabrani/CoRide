<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'trajet_id' => ['required', 'integer', 'exists:trajets,id'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $trajetId = $this->input('trajet_id');
            $passagerId = $this->user()?->id;

            if (!$trajetId || !$passagerId) {
                return;
            }

            // Règle 1 : pas de doublon
            $dejaReserve = Reservation::where('trajet_id', $trajetId)
                ->where('passager_id', $passagerId)
                ->exists();

            if ($dejaReserve) {
                $validator->errors()->add(
                    'trajet_id',
                    'Vous avez déjà réservé ce trajet.'
                );
                return;
            }

            // Règle 2 : places disponibles
            $trajet = $this->trajetAvecPlacesRestantes($trajetId);

            if ($trajet && $trajet->placesRestantes() <= 0) {
                $validator->errors()->add(
                    'trajet_id',
                    'Ce trajet est complet, aucune place disponible.'
                );
            }
        });
    }

    private function trajetAvecPlacesRestantes(int $trajetId)
    {
        return \App\Models\Trajet::find($trajetId);
    }
}

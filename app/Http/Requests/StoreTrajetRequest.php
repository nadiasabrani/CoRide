<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTrajetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'depart'           => 'required|string|max:255',
            'destination'      => 'required|string|max:255',
            'date_depart'      => 'required|date|after_or_equal:today',
            'heure_depart'     => 'required|date_format:H:i',
            'prix'             => 'required|numeric|min:0|max:9999',
            'places'           => 'required|integer|min:1|max:8',
            'jours_recurrence' => 'nullable|array',
            'jours_recurrence.*' => 'in:lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche',
        ];
    }

    public function messages(): array
    {
        return [
            'date_depart.after_or_equal' => 'La date de départ doit être aujourd\'hui ou dans le futur.',
            'places.max'                 => 'Le nombre de places ne peut pas dépasser 8.',
        ];
    }
}

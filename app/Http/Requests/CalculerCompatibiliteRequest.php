<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculerCompatibiliteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ville_depart' => ['required', 'string', 'max:255'],
            'ville_arrivee' => ['required', 'string', 'max:255'],
            'horaire' => ['required', 'string', 'max:20'],
        ];
    }
}

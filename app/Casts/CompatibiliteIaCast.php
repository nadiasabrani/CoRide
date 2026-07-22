<?php

namespace App\Casts;

use App\ValueObjects\CompatibiliteResultat;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class CompatibiliteIaCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?CompatibiliteResultat
    {
        if (is_null($value)) {
            return null;
        }

        $data = is_string($value) ? json_decode($value, true) : $value;

        if (!is_array($data)) {
            return null;
        }

        return CompatibiliteResultat::fromArray($data);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if (is_null($value)) {
            return null;
        }

        if ($value instanceof CompatibiliteResultat) {
            return json_encode($value->toArray());
        }

        if (is_array($value)) {
            return json_encode(CompatibiliteResultat::fromArray($value)->toArray());
        }

        throw new \InvalidArgumentException('La valeur doit être un CompatibiliteResultat ou un tableau valide.');
    }
}

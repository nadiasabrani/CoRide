<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\StoreReservationRequest;
use PHPUnit\Framework\TestCase;

class StoreReservationRequestTest extends TestCase
{
    public function test_la_requete_autorise_toujours(): void
    {
        $request = new StoreReservationRequest();
        $this->assertTrue($request->authorize());
    }

    public function test_les_regles_de_base_sont_definies(): void
    {
        $request = new StoreReservationRequest();
        $rules = $request->rules();

        $this->assertArrayHasKey('trajet_id', $rules);
        $this->assertContains('required', $rules['trajet_id']);
    }
}
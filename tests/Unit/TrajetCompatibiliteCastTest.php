<?php

namespace Tests\Unit;

use App\Casts\CompatibiliteIaCast;
use App\Models\TrajetCompatibilite;
use PHPUnit\Framework\TestCase;

class TrajetCompatibiliteCastTest extends TestCase
{
    public function test_le_cast_est_bien_configure(): void
    {
        $model = new TrajetCompatibilite();
        $casts = $model->getCasts();

        $this->assertEquals(CompatibiliteIaCast::class, $casts['donnees_ia']);
    }
}
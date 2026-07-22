<?php

namespace Tests\Unit;

use App\ValueObjects\CompatibiliteResultat;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CompatibiliteResultatTest extends TestCase
{
    public function test_creation_valide(): void
    {
        $resultat = new CompatibiliteResultat(
            score: 85,
            justification: 'Horaires très proches, même trajet',
            horaireSuggere: '08:15'
        );

        $this->assertEquals(85, $resultat->score);
        $this->assertTrue($resultat->estBonneCompatibilite());
    }

    public function test_score_invalide_leve_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new CompatibiliteResultat(score: 150, justification: 'Test');
    }

    public function test_from_array(): void
    {
        $resultat = CompatibiliteResultat::fromArray([
            'score' => 60,
            'justification' => 'Compatibilité moyenne',
            'horaire_suggere' => '08:30',
        ]);

        $this->assertEquals(60, $resultat->score);
        $this->assertFalse($resultat->estBonneCompatibilite());
    }
}
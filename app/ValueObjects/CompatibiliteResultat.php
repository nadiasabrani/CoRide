<?php

namespace App\ValueObjects;

use InvalidArgumentException;

class CompatibiliteResultat
{
    public function __construct(
        public readonly int $score,
        public readonly string $justification,
        public readonly ?string $horaireSuggere = null,
    ) {
        if ($score < 0 || $score > 100) {
            throw new InvalidArgumentException("Le score doit être compris entre 0 et 100, {$score} donné.");
        }
    }

    public static function fromArray(array $data): self
    {
        if (!isset($data['score']) || !isset($data['justification'])) {
            throw new InvalidArgumentException('Les clés "score" et "justification" sont obligatoires.');
        }

        return new self(
            score: (int) $data['score'],
            justification: (string) $data['justification'],
            horaireSuggere: $data['horaire_suggere'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'score' => $this->score,
            'justification' => $this->justification,
            'horaire_suggere' => $this->horaireSuggere,
        ];
    }

    public function estBonneCompatibilite(): bool
    {
        return $this->score >= 70;
    }
}
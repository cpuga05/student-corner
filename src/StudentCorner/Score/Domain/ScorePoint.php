<?php

declare(strict_types=1);

namespace StudentCorner\Score\Domain;

use Shared\Domain\ValueObject\IntegerValueObject;

final class ScorePoint extends IntegerValueObject
{
    public static function zero(): self
    {
        return new self(0);
    }
}

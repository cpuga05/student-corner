<?php

declare(strict_types=1);

namespace StudentCorner\OfferCounter\Domain;

use Shared\Domain\ValueObject\IntegerValueObject;

final class OfferCounterTotal extends IntegerValueObject
{
    public static function initialize(): self
    {
        return new self(0);
    }

    public function increment(): self
    {
        return new self($this->value() + 1);
    }
}

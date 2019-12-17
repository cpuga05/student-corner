<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

abstract class StringValueObject
{
    /** @var string */
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function equals(self $value): bool
    {
        return $value->value() === $this->value();
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }
}

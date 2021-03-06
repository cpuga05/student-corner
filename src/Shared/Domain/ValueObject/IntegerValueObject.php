<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

abstract class IntegerValueObject
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function equals(self $value): bool
    {
        return $value->value() === $this->value();
    }

    public function add(self $value): self
    {
        return new static($this->value() + $value->value());
    }

    public function subtract(self $value): self
    {
        return new static($this->value() - $value->value());
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value();
    }
}

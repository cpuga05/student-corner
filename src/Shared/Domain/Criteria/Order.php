<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;

use function sprintf;

final class Order
{
    private OrderBy $by;
    private OrderType $type;

    public function __construct(OrderBy $by, OrderType $type)
    {
        $this->by = $by;
        $this->type = $type;
    }

    public static function fromValues(?string $by, ?string $type): self
    {
        return null === $by ? self::none() : new self(new OrderBy($by), new OrderType($type));
    }

    public static function createDesc(OrderBy $by): self
    {
        return new self($by, new OrderType(OrderType::DESC));
    }

    public static function none(): self
    {
        return new self(new OrderBy(''), new OrderType(OrderType::NONE));
    }

    public function isNone(): bool
    {
        return $this->type->isNone();
    }

    public function by(): OrderBy
    {
        return $this->by;
    }

    public function type(): OrderType
    {
        return $this->type;
    }

    public function serialize(): string
    {
        return sprintf('%s.%s', $this->by->value(), $this->type->value());
    }
}

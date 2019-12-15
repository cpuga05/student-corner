<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;

use function sprintf;

final class Criteria
{
    /** @var Filters */
    private $filters;
    /** @var Order */
    private $order;
    /** @var int|null */
    private $offset;
    /** @var int|null */
    private $limit;

    public function __construct(Filters $filters, Order $order, ?int $offset, ?int $limit)
    {
        $this->filters = $filters;
        $this->order = $order;
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function hasFilters(): bool
    {
        return 0 < $this->filters->count();
    }

    public function hasOrder(): bool
    {
        return !$this->order->isNone();
    }

    public function plainFilters(): array
    {
        return $this->filters->filters();
    }

    public function filters(): Filters
    {
        return $this->filters;
    }

    public function order(): Order
    {
        return $this->order;
    }

    public function offset(): ?int
    {
        return $this->offset;
    }

    public function limit(): ?int
    {
        return $this->limit;
    }

    public function serialize(): string
    {
        return sprintf(
            '%s~~%s~~%s~~%s',
            $this->filters->serialize(),
            $this->order->serialize(),
            $this->offset,
            $this->limit
        );
    }
}

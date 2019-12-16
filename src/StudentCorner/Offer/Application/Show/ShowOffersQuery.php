<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Application\Show;

use Shared\Domain\Bus\Query\Query;

final class ShowOffersQuery implements Query
{
    /** @var array */
    private $filters;
    /** @var string */
    private $orderBy;
    /** @var string */
    private $order;
    /** @var int */
    private $limit;
    /** @var int */
    private $offset;

    public function __construct(
        array $filters,
        string $orderBy = null,
        string $order = null,
        int $limit = null,
        int $offset = null
    ) {
        $this->filters = $filters;
        $this->orderBy = $orderBy;
        $this->order = $order;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function filters(): array
    {
        return $this->filters;
    }

    public function orderBy(): string
    {
        return $this->orderBy;
    }

    public function order(): string
    {
        return $this->order;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function offset(): int
    {
        return $this->offset;
    }
}

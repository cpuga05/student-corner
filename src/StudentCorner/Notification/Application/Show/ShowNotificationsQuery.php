<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Application\Show;

use Shared\Domain\Bus\Query\Query;

final class ShowNotificationsQuery implements Query
{
    private array $filters;
    private string $orderBy;
    private string $order;
    private int $limit;
    private int $offset;

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

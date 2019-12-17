<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Application;

use Shared\Domain\Bus\Query\Response;

final class CounterNotificationsResponse implements Response
{
    private int $counter;

    public function __construct(int $counter)
    {
        $this->counter = $counter;
    }

    public function counter(): int
    {
        return $this->counter;
    }
}

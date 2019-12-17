<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Application\UnreadCounter;

use Shared\Domain\Bus\Query\Query;

final class UnreadCounterNotificationsQuery implements Query
{
    private string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function userId(): string
    {
        return $this->userId;
    }
}

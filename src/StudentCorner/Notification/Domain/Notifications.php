<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Domain;

use Shared\Domain\Collection;

final class Notifications extends Collection
{
    protected function type(): string
    {
        return Notification::class;
    }
}

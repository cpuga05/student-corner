<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Infrastructure\Persistence\Doctrine\Types;

use Shared\Infrastructure\Persistence\Doctrine\DBAL\UuidType;
use StudentCorner\Notification\Domain\NotificationDestination;

final class NotificationDestinationType extends UuidType
{
    public static function customTypeName(): string
    {
        return 'NotificationDestination';
    }

    protected function typeClassName(): string
    {
        return NotificationDestination::class;
    }
}

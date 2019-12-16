<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Infrastructure\Persistence\Doctrine\Types;

use Shared\Infrastructure\Persistence\Doctrine\DBAL\UuidType;
use StudentCorner\Notification\Domain\NotificationId;

final class NotificationIdType extends UuidType
{
    public static function customTypeName(): string
    {
        return 'NotificationId';
    }

    protected function typeClassName(): string
    {
        return NotificationId::class;
    }
}

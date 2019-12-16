<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Infrastructure\Persistence\Doctrine\Types;

use Shared\Infrastructure\Persistence\Doctrine\DBAL\EnumType;
use StudentCorner\Notification\Domain\NotificationStatus;

final class NotificationStatusType extends EnumType
{
    public static function customTypeName(): string
    {
        return 'NotificationStatus';
    }

    protected function typeClassName(): string
    {
        return NotificationStatus::class;
    }
}

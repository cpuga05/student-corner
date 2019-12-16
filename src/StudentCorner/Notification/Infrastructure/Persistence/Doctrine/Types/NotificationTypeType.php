<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Infrastructure\Persistence\Doctrine\Types;

use Shared\Infrastructure\Persistence\Doctrine\DBAL\StringValueObjectType;
use StudentCorner\Notification\Domain\NotificationType;

final class NotificationTypeType extends StringValueObjectType
{
    public static function customTypeName(): string
    {
        return 'NotificationType';
    }

    protected function typeClassName(): string
    {
        return NotificationType::class;
    }
}

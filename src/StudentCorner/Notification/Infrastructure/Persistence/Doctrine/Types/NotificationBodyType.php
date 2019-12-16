<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Infrastructure\Persistence\Doctrine\Types;

use Shared\Infrastructure\Persistence\Doctrine\DBAL\StringValueObjectType;
use StudentCorner\Notification\Domain\NotificationBody;

final class NotificationBodyType extends StringValueObjectType
{
    public static function customTypeName(): string
    {
        return 'NotificationBody';
    }

    protected function typeClassName(): string
    {
        return NotificationBody::class;
    }
}

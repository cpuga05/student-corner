<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Domain;

use InvalidArgumentException;
use Shared\Domain\ValueObject\Enum;

final class NotificationStatus extends Enum
{
    public const READ = 'read';
    public const UNREAD = 'unread';

    protected function throwExceptionForInvalidValue($value): void
    {
        throw new InvalidArgumentException($value);
    }
}

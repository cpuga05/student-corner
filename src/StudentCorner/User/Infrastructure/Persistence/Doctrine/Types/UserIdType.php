<?php

declare(strict_types=1);

namespace StudentCorner\User\Infrastructure\Persistence\Doctrine\Types;

use Shared\Infrastructure\Persistence\Doctrine\DBAL\UuidType;
use StudentCorner\User\Domain\UserId;

final class UserIdType extends UuidType
{
    public static function customTypeName(): string
    {
        return 'UserId';
    }

    protected function typeClassName(): string
    {
        return UserId::class;
    }
}

<?php

declare(strict_types=1);

namespace StudentCorner\User\Infrastructure\Persistence\Doctrine\Types;

use Shared\Infrastructure\Persistence\Doctrine\DBAL\StringValueObjectType;
use StudentCorner\User\Domain\UserEmail;

final class UserEmailType extends StringValueObjectType
{
    public static function customTypeName(): string
    {
        return 'UserEmail';
    }

    protected function typeClassName(): string
    {
        return UserEmail::class;
    }
}

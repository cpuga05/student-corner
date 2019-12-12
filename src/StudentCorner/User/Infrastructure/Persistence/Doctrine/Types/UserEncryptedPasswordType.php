<?php

declare(strict_types=1);

namespace StudentCorner\User\Infrastructure\Persistence\Doctrine\Types;

use Shared\Infrastructure\Persistence\Doctrine\DBAL\StringValueObjectType;
use StudentCorner\User\Domain\UserEncryptedPassword;

final class UserEncryptedPasswordType extends StringValueObjectType
{
    public static function customTypeName(): string
    {
        return 'UserEncryptedPassword';
    }

    protected function typeClassName(): string
    {
        return UserEncryptedPassword::class;
    }
}

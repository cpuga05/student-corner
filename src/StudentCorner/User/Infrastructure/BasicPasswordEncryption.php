<?php

declare(strict_types=1);

namespace StudentCorner\User\Infrastructure;

use StudentCorner\User\Domain\PasswordEncryption;
use StudentCorner\User\Domain\UserEncryptedPassword;
use StudentCorner\User\Domain\UserPassword;

use function password_hash;
use function password_verify;

use const PASSWORD_BCRYPT;

final class BasicPasswordEncryption implements PasswordEncryption
{
    public function encrypt(UserPassword $password): UserEncryptedPassword
    {
        return new UserEncryptedPassword(password_hash($password->value(), PASSWORD_BCRYPT, ['cost' => 10]));
    }

    public function verify(UserPassword $password, UserEncryptedPassword $encryptedPassword): bool
    {
        return password_verify($password->value(), $encryptedPassword->value());
    }
}

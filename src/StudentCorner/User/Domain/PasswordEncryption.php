<?php

declare(strict_types=1);

namespace StudentCorner\User\Domain;

interface PasswordEncryption
{
    public function encrypt(UserPassword $password): UserEncryptedPassword;

    public function verify(UserPassword $password, UserEncryptedPassword $encryptedPassword): bool;
}

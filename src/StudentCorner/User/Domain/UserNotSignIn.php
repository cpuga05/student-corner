<?php

declare(strict_types=1);

namespace StudentCorner\User\Domain;

use Shared\Domain\DomainError;

final class UserNotSignIn extends DomainError
{
    public function errorCode(): string
    {
        return 'user.not_sign_in';
    }

    protected function errorMessage(): string
    {
        return 'The user not sign in';
    }
}

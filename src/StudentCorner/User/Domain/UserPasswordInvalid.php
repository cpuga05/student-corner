<?php

declare(strict_types=1);

namespace StudentCorner\User\Domain;

use Shared\Domain\DomainError;

use function sprintf;

final class UserPasswordInvalid extends DomainError
{
    /** @var UserEmail */
    private UserEmail $email;

    public function __construct(UserEmail $email)
    {
        $this->email = $email;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'user.password_invalid';
    }

    protected function errorMessage(): string
    {
        return sprintf('The password for <%s> are invalid', $this->email->value());
    }
}

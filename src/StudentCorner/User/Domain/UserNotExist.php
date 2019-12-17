<?php

declare(strict_types=1);

namespace StudentCorner\User\Domain;

use Shared\Domain\DomainError;

use function sprintf;

final class UserNotExist extends DomainError
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
        return 'user.not_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('The user <%s> not exist', $this->email->value());
    }
}

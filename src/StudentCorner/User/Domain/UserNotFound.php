<?php

declare(strict_types=1);

namespace StudentCorner\User\Domain;

use Shared\Domain\DomainError;

use function sprintf;

final class UserNotFound extends DomainError
{
    /** @var UserId */
    private UserId $id;

    public function __construct(UserId $id)
    {
        $this->id = $id;
    }

    public function errorCode(): string
    {
        return 'user.not_found';
    }

    protected function errorMessage(): string
    {
        return sprintf('The user <%s> not exist', $this->id->value());
    }
}

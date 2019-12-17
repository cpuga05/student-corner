<?php

declare(strict_types=1);

namespace StudentCorner\User\Application\SignIn;

use StudentCorner\User\Domain\Authenticate;
use StudentCorner\User\Domain\UserEmail;
use StudentCorner\User\Domain\UserPassword;

final class SignInUserService
{
    private Authenticate $authenticate;

    public function __construct(Authenticate $authenticate)
    {
        $this->authenticate = $authenticate;
    }

    public function __invoke(UserEmail $email, UserPassword $password): void
    {
        $this->authenticate->authenticate($email, $password);
    }
}

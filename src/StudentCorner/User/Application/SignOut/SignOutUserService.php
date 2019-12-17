<?php

declare(strict_types=1);

namespace StudentCorner\User\Application\SignOut;

use StudentCorner\User\Domain\Authenticate;

final class SignOutUserService
{
    private Authenticate $authenticate;

    public function __construct(Authenticate $authenticate)
    {
        $this->authenticate = $authenticate;
    }

    public function __invoke(): void
    {
        $this->authenticate->logout();
    }
}

<?php

declare(strict_types=1);

namespace StudentCorner\User\Application\SignIn;

use Shared\Domain\Bus\Command\CommandHandler;
use StudentCorner\User\Domain\UserEmail;
use StudentCorner\User\Domain\UserPassword;

final class SignInUserCommandHandler implements CommandHandler
{
    private SignInUserService $service;

    public function __construct(SignInUserService $service)
    {
        $this->service = $service;
    }

    public function __invoke(SignInUserCommand $command): void
    {
        $email = new UserEmail($command->email());
        $password = new UserPassword($command->password());

        $this->service->__invoke($email, $password);
    }
}

<?php

declare(strict_types=1);

namespace StudentCorner\User\Application\SignOut;

use Shared\Domain\Bus\Command\CommandHandler;

final class SignOutUserCommandHandler implements CommandHandler
{
    private SignOutUserService $service;

    public function __construct(SignOutUserService $service)
    {
        $this->service = $service;
    }

    public function __invoke(SignOutUserCommand $command): void
    {
        $this->service->__invoke();
    }
}

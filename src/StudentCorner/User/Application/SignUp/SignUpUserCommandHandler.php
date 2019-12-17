<?php

declare(strict_types=1);

namespace StudentCorner\User\Application\SignUp;

use Shared\Domain\Bus\Command\CommandHandler;
use StudentCorner\User\Domain\UserEmail;
use StudentCorner\User\Domain\UserId;
use StudentCorner\User\Domain\UserPassword;

final class SignUpUserCommandHandler implements CommandHandler
{
    /** @var SignUpUserService */
    private SignUpUserService $service;

    public function __construct(SignUpUserService $service)
    {
        $this->service = $service;
    }

    public function __invoke(SignUpUserCommand $command): void
    {
        $id = new UserId($command->id());
        $email = new UserEmail($command->email());
        $password = new UserPassword($command->password());

        $this->service->__invoke($id, $email, $password);
    }
}

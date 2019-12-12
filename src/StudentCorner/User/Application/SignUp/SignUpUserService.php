<?php

declare(strict_types=1);

namespace StudentCorner\User\Application\SignUp;

use Shared\Domain\Bus\Event\EventBus;
use StudentCorner\User\Domain\PasswordEncryption;
use StudentCorner\User\Domain\User;
use StudentCorner\User\Domain\UserAlreadyExist;
use StudentCorner\User\Domain\UserEmail;
use StudentCorner\User\Domain\UserId;
use StudentCorner\User\Domain\UserPassword;
use StudentCorner\User\Domain\UserRepository;

final class SignUpUserService
{
    /** @var PasswordEncryption */
    private $passwordEncryption;
    /** @var UserRepository */
    private $repository;
    /** @var EventBus */
    private $eventBus;

    public function __construct(PasswordEncryption $passwordEncryption, UserRepository $repository, EventBus $eventBus)
    {
        $this->passwordEncryption = $passwordEncryption;
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(UserId $id, UserEmail $email, UserPassword $password): void
    {
        if (null !== $this->repository->findByEmail($email)) {
            throw new UserAlreadyExist($email);
        }

        $encryptedPassword = $this->passwordEncryption->encrypt($password);
        $user = User::create($id, $email, $encryptedPassword);

        $this->repository->save($user);
        $this->eventBus->publish(...$user->pullDomainEvents());
    }
}

<?php

declare(strict_types=1);

namespace StudentCorner\User\Domain;

use Shared\Domain\Bus\Event\EventBus;

abstract class Authenticate
{
    /** @var PasswordEncryption */
    private $passwordEncryption;
    /** @var UserRepository */
    private $userRepository;
    /** @var EventBus */
    private $eventBus;

    public function __construct(
        PasswordEncryption $passwordEncryption,
        UserRepository $userRepository,
        EventBus $eventBus
    ) {
        $this->passwordEncryption = $passwordEncryption;
        $this->userRepository = $userRepository;
        $this->eventBus = $eventBus;
    }

    public function authenticate(
        UserEmail $email,
        UserPassword $password
    ): void {
        if ($this->isAlreadyAuthenticated()) {
            return;
        }

        $user = $this->userRepository->findByEmail($email);

        if (null === $user) {
            throw new UserNotExist($email);
        }

        if (!$this->passwordEncryption->verify($password, $user->password())) {
            throw new UserPasswordInvalid($email);
        }

        $this->persistAuthentication($user);

        $userSecurityToken = $this->userSecurityToken();

        $this->eventBus->publish(UserSignedInDomainEvent::create($userSecurityToken));
    }

    public function logout(): void
    {
        $userSecurityToken = $this->userSecurityToken();

        $this->clearAuthentication();
        $this->eventBus->publish(UserSignedOutDomainEvent::create($userSecurityToken));
    }

    abstract public function persistAuthentication(User $user): void;

    abstract public function clearAuthentication(): void;

    abstract public function isAlreadyAuthenticated(): bool;

    abstract public function userSecurityToken(): UserSecurityToken;
}

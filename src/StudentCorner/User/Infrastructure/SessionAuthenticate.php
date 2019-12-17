<?php

declare(strict_types=1);

namespace StudentCorner\User\Infrastructure;

use Shared\Domain\Bus\Event\EventBus;
use StudentCorner\User\Domain\Authenticate;
use StudentCorner\User\Domain\PasswordEncryption;
use StudentCorner\User\Domain\User;
use StudentCorner\User\Domain\UserNotSignIn;
use StudentCorner\User\Domain\UserRepository;
use StudentCorner\User\Domain\UserSecurityToken;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SessionAuthenticate extends Authenticate
{
    private SessionInterface $session;

    public function __construct(
        PasswordEncryption $passwordEncryption,
        UserRepository $userRepository,
        EventBus $eventBus,
        SessionInterface $session
    ) {
        parent::__construct($passwordEncryption, $userRepository, $eventBus);
        $this->session = $session;
    }

    public function persistAuthentication(User $user): void
    {
        $this->session->set('user', UserSecurityToken::fromUser($user));
    }

    public function clearAuthentication(): void
    {
        $this->session->remove('user');
    }

    public function isAlreadyAuthenticated(): bool
    {
        return $this->session->has('user');
    }

    public function userSecurityToken(): UserSecurityToken
    {
        if (!$this->isAlreadyAuthenticated()) {
            throw new UserNotSignIn();
        }

        return $this->session->get('user');
    }
}

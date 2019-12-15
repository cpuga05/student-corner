<?php

declare(strict_types=1);

namespace StudentCorner\Shared\Infrastructure\Symfony;

use StudentCorner\User\Domain\Authenticate;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class AddUserIdMiddleware
{
    /** @var Authenticate */
    private $authenticate;

    public function __construct(Authenticate $authenticate)
    {
        $this->authenticate = $authenticate;
    }

    public function __invoke(RequestEvent $event): void
    {
        if (!$this->authenticate->isAlreadyAuthenticated()) {
            return;
        }

        $event->getRequest()->attributes->set('user_id', $this->authenticate->userSecurityToken()->id()->value());
        $event->getRequest()->request->set('user_id', $this->authenticate->userSecurityToken()->id()->value());
    }
}

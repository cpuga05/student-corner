<?php

declare(strict_types=1);

namespace StudentCorner\Shared\Infrastructure\Symfony;

use StudentCorner\User\Domain\Authenticate;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class SessionAuthMiddleware
{
    /** @var Authenticate */
    private Authenticate $authenticate;

    public function __construct(Authenticate $authenticate)
    {
        $this->authenticate = $authenticate;
    }

    public function __invoke(RequestEvent $event): void
    {
        $shouldAuthenticate = $event->getRequest()->attributes->get('auth', null);

        if (null === $shouldAuthenticate) {
            return;
        }

        if ($this->authenticate->isAlreadyAuthenticated() === $shouldAuthenticate) {
            return;
        }

        if ($shouldAuthenticate) {
            $event->setResponse(new RedirectResponse('/sign-in'));
            return;
        }

        $event->setResponse(new RedirectResponse('/'));
    }
}

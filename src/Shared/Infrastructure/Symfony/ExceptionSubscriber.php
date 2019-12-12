<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Symfony;

use StudentTracker\Domain\Model\User\Exception\UserNotSignIn;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                ['processException', 10],
                ['logException', 0],
                ['notifyException', -10],
            ],
        ];
    }

    public function logException(ExceptionEvent $event)
    {
    }

    public function notifyException(ExceptionEvent $event)
    {
    }

    public function processException(ExceptionEvent $event)
    {
        if ($event->getException() instanceof UserNotSignIn) {
            $event->setResponse(new RedirectResponse('/sign-in'));
        } else {
            if ($event->getException() instanceof FileNotFoundException) {
                $event->setResponse(new Response('', Response::HTTP_NOT_FOUND));
            }
        }
    }
}

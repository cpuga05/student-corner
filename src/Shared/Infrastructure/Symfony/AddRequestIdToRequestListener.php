<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Symfony;

use Shared\Domain\ValueObject\Uuid;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class AddRequestIdToRequestListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $request->request->set('request_id', Uuid::random()->value());
    }
}

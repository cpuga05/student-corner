<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Symfony;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelInterface;

final class FormatJsonResponseListener
{
    /** @var KernelInterface */
    private KernelInterface $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $response = $event->getResponse();

        if (!$response instanceof JsonResponse) {
            return;
        }

//        $request = $event->getRequest();
// TODO: Can check query params to show pretty json
        if ($this->kernel->getEnvironment() !== 'dev') {
            return;
        }

        $response->setEncodingOptions(JSON_PRETTY_PRINT);
        $event->setResponse($response);
    }
}

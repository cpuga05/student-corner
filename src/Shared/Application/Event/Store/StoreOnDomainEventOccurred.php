<?php

declare(strict_types=1);

namespace Shared\Application\Event\Store;

use Shared\Domain\Bus\Event\DomainEvent;
use Shared\Domain\Bus\Event\DomainEventSubscriber;
use Shared\Domain\Bus\Event\StoredEvent;

final class StoreOnDomainEventOccurred implements DomainEventSubscriber
{
    private StoreEventService $service;

    public function __construct(StoreEventService $service)
    {
        $this->service = $service;
    }

    public static function subscribedTo(): array
    {
        return [DomainEvent::class];
    }

    public function __invoke(DomainEvent $domainEvent): void
    {
        $storedEvent = StoredEvent::fromDomainEvent($domainEvent);

        $this->service->__invoke($storedEvent);
    }
}

<?php

declare(strict_types=1);

namespace Shared\Application\Event\Store;

use Shared\Domain\Bus\Event\EventStore;
use Shared\Domain\Bus\Event\StoredEvent;

final class StoreEventService
{
    /** @var EventStore */
    private EventStore $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function __invoke(StoredEvent $storedEvent): void
    {
        $this->eventStore->append($storedEvent);
    }
}

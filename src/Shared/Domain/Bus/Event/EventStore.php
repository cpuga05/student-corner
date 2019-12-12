<?php

declare(strict_types=1);

namespace Shared\Domain\Bus\Event;

use Shared\Domain\Criteria\Criteria;

interface EventStore
{
    public function append(StoredEvent $storedEvent): void;

    public function allStoredEventsSince(?PublishedEvent $publishedEvent): StoredEvents;

    public function all(): StoredEvents;

    public function matching(Criteria $criteria): StoredEvents;
}

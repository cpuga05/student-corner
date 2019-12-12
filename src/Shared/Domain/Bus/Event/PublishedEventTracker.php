<?php

namespace Shared\Domain\Bus\Event;

interface PublishedEventTracker
{
    public function mostRecentPublishedEvent(string $channel): ?PublishedEvent;

    public function trackMostRecentPublishedEvent(string $channel, ?StoredEvent $event): void;
}

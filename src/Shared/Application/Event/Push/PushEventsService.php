<?php

declare(strict_types=1);

namespace Shared\Application\Event\Push;

use Exception;
use Shared\Domain\Bus\Event\EventProducer;
use Shared\Domain\Bus\Event\EventStore;
use Shared\Domain\Bus\Event\PublishedEventTracker;

final class PushEventsService
{
    private EventStore $eventStore;
    private PublishedEventTracker $publishedEventTracker;
    private EventProducer $eventProducer;

    public function __construct(
        EventStore $eventStore,
        PublishedEventTracker $publishedEventTracker,
        EventProducer $eventProducer
    ) {
        $this->eventStore = $eventStore;
        $this->publishedEventTracker = $publishedEventTracker;
        $this->eventProducer = $eventProducer;
    }

    public function __invoke(string $channel, bool $force = false): int
    {
        $publishedEvent = $this->publishedEventTracker->mostRecentPublishedEvent($channel);

        if ($force && $publishedEvent) {
            $publishedEvent->updateLastEventPublishedId(0);
        }

        $storedEvents = $this->eventStore->allStoredEventsSince($publishedEvent);

        if (0 === $storedEvents->count()) {
            return 0;
        }

        $this->eventProducer->open($channel);

        $publishedEvents = 0;
        $lastStoredEvent = null;

        try {
            foreach ($storedEvents as $storedEvent) {
                $this->eventProducer->send($storedEvent);
                $lastStoredEvent = $storedEvent;
                $publishedEvents++;
            }
        } catch (Exception $exception) {
        }

        $this->eventProducer->close($channel);
        $this->publishedEventTracker->trackMostRecentPublishedEvent($channel, $lastStoredEvent);

        return $publishedEvents;
    }
}

<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Event;

use Doctrine\ORM\EntityManager;
use Shared\Domain\Bus\Event\PublishedEvent;
use Shared\Domain\Bus\Event\PublishedEventTracker;
use Shared\Domain\Bus\Event\StoredEvent;

final class DoctrinePublishedEventTracker implements PublishedEventTracker
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function mostRecentPublishedEvent(string $channel): ?PublishedEvent
    {
        return $this->entityManager->getRepository(PublishedEvent::class)->findOneBy(['channel' => $channel]);
    }

    public function trackMostRecentPublishedEvent(string $channel, ?StoredEvent $event): void
    {
        if (!$event) {
            return;
        }

        $lastId = $event->id();
        $publishedEvent = $this->entityManager->getRepository(PublishedEvent::class)->findOneBy(
            ['channel' => $channel]
        );

        if (!$publishedEvent) {
            $publishedEvent = new PublishedEvent($channel, $lastId);
        }

        $publishedEvent->updateLastId($lastId);
        $this->entityManager->persist($publishedEvent);
        $this->entityManager->flush($publishedEvent);
    }
}

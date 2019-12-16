<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Event;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Shared\Domain\Bus\Event\EventStore;
use Shared\Domain\Bus\Event\PublishedEvent;
use Shared\Domain\Bus\Event\StoredEvent;
use Shared\Domain\Bus\Event\StoredEvents;
use Shared\Domain\Criteria\Criteria;
use Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;

final class DoctrineEventStore implements EventStore
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function append(StoredEvent $storedEvent): void
    {
        $this->entityManager->persist($storedEvent);
    }

    public function allStoredEventsSince(?PublishedEvent $publishedEvent): StoredEvents
    {
        $query = $this->getRepository()->createQueryBuilder('e');

        if ($publishedEvent) {
            $query->where('e.id > :id');
            $query->setParameter('id', $publishedEvent->lastEventPublishedId());
        }

        $query->orderBy('e.id');

        return new StoredEvents($query->getQuery()->getResult());
    }

    public function all(): StoredEvents
    {
        $storedEvents = $this->getRepository()->findAll();

        return new StoredEvents($storedEvents);
    }

    public function matching(Criteria $criteria): StoredEvents
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
        $storedEvents = $this->getRepository()->matching($doctrineCriteria)->toArray();

        return new StoredEvents($storedEvents);
    }

    private function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(StoredEvent::class);
    }
}

<?php

declare(strict_types=1);

namespace StudentCorner\OfferCounter\Application\Increment;

use Shared\Domain\Bus\Event\EventBus;
use StudentCorner\Offer\Domain\OfferId;
use StudentCorner\OfferCounter\Domain\OfferCounter;
use StudentCorner\OfferCounter\Domain\OfferCounterRepository;
use StudentCorner\User\Domain\UserId;

final class IncrementOfferCounterService
{
    private OfferCounterRepository $repository;
    private EventBus $eventBus;

    public function __construct(OfferCounterRepository $repository, EventBus $eventBus)
    {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(UserId $userId, OfferId $offerId): void
    {
        $offerCounter = $this->repository->findByUserId($userId) ?: OfferCounter::initialize($userId);

        $offerCounter->increment($offerId);
        $this->repository->save($offerCounter);
        $this->eventBus->publish(...$offerCounter->pullDomainEvents());
    }
}

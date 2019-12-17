<?php

declare(strict_types=1);

namespace StudentCorner\OfferCounter\Application\Increment;

use Shared\Domain\Bus\Event\DomainEventSubscriber;
use StudentCorner\Offer\Domain\OfferId;
use StudentCorner\Offer\Domain\OfferPublished;
use StudentCorner\User\Domain\UserId;

final class IncrementOfferCounterOnOfferPublished implements DomainEventSubscriber
{
    private IncrementOfferCounterService $service;

    public function __construct(IncrementOfferCounterService $service)
    {
        $this->service = $service;
    }

    public static function subscribedTo(): array
    {
        return [OfferPublished::class];
    }

    public function __invoke(OfferPublished $offerPublished): void
    {
        $userId = new UserId($offerPublished->userId());
        $offerId = new OfferId($offerPublished->aggregateId());

        $this->service->__invoke($userId, $offerId);
    }
}

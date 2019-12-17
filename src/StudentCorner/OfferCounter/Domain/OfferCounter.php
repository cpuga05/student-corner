<?php

declare(strict_types=1);

namespace StudentCorner\OfferCounter\Domain;

use Shared\Domain\Aggregate\AggregateRoot;
use StudentCorner\Offer\Domain\OfferId;
use StudentCorner\User\Domain\UserId;

use function Lambdish\Phunctional\search;

final class OfferCounter extends AggregateRoot
{
    private UserId $userId;
    private OfferCounterTotal $total;
    /** @var OfferId[] */
    private array $existingOffers;

    public function __construct(UserId $userId, OfferCounterTotal $total, OfferId ...$existingOffers)
    {
        $this->userId = $userId;
        $this->total = $total;
        $this->existingOffers = $existingOffers;
    }

    public static function initialize(UserId $userId): self
    {
        $offerCounter = new self($userId, OfferCounterTotal::initialize());

        $offerCounter->record(OfferCounterInitialized::create($offerCounter));

        return $offerCounter;
    }

    public function increment(OfferId $offerId): void
    {
        $existingOffer = search(fn(OfferId $other) => $offerId->equals($other), $this->existingOffers());

        if (null !== $existingOffer) {
            return;
        }

        $this->total = $this->total->increment();
        $this->existingOffers[] = $offerId;

        $this->record(OfferCounterIncremented::create($this));
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function total(): OfferCounterTotal
    {
        return $this->total;
    }

    public function existingOffers(): array
    {
        return $this->existingOffers;
    }
}

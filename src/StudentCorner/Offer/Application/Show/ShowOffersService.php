<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Application\Show;

use Shared\Domain\Criteria\Criteria;
use StudentCorner\Offer\Domain\OfferRepository;
use StudentCorner\Offer\Domain\Offers;

final class ShowOffersService
{
    /** @var OfferRepository */
    private OfferRepository $repository;

    public function __construct(OfferRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Criteria $criteria): Offers
    {
        return $this->repository->match($criteria);
    }
}

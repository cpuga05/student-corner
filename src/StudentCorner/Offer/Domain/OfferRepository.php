<?php

namespace StudentCorner\Offer\Domain;

use Shared\Domain\Criteria\Criteria;

interface OfferRepository
{
    public function save(Offer $offer): void;

    public function findById(OfferId $id): ?Offer;

    public function match(Criteria $criteria): Offers;
}

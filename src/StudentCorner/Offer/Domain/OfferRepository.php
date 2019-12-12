<?php

namespace StudentCorner\Offer\Domain;

interface OfferRepository
{
    public function save(Offer $offer): void;

    public function findById(OfferId $id): ?Offer;
}

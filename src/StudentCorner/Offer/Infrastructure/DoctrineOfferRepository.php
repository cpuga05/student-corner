<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Infrastructure;

use Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use StudentCorner\Offer\Domain\Offer;
use StudentCorner\Offer\Domain\OfferId;
use StudentCorner\Offer\Domain\OfferRepository;

final class DoctrineOfferRepository extends DoctrineRepository implements OfferRepository
{
    protected function entity(): String
    {
        return Offer::class;
    }

    public function save(Offer $offer): void
    {
        $this->persist($offer);
    }

    public function findById(OfferId $id): ?Offer
    {
        return $this->repository()->find($id);
    }
}

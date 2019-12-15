<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Infrastructure;

use Shared\Domain\Criteria\Criteria;
use Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
use Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use StudentCorner\Offer\Domain\Offer;
use StudentCorner\Offer\Domain\OfferId;
use StudentCorner\Offer\Domain\OfferRepository;
use StudentCorner\Offer\Domain\Offers;

use function dump;

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

    public function match(Criteria $criteria): Offers
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
        $offers = $this->repository()->matching($doctrineCriteria)->toArray();

        return new Offers($offers);
    }
}

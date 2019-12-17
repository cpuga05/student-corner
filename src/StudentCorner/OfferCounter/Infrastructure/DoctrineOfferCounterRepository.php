<?php

declare(strict_types=1);

namespace StudentCorner\OfferCounter\Infrastructure;

use Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use StudentCorner\OfferCounter\Domain\OfferCounter;
use StudentCorner\OfferCounter\Domain\OfferCounterRepository;
use StudentCorner\User\Domain\UserId;

final class DoctrineOfferCounterRepository extends DoctrineRepository implements OfferCounterRepository
{
    protected function entity(): String
    {
        return OfferCounter::class;
    }

    public function save(OfferCounter $offerCounter): void
    {
        $this->persist($offerCounter);
    }

    public function findByUserId(UserId $userId): ?OfferCounter
    {
        return $this->repository()->find($userId);
    }
}

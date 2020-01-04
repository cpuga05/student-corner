<?php

declare(strict_types=1);

namespace StudentCorner\OfferCounter\Application\Show;

use StudentCorner\OfferCounter\Domain\OfferCounter;
use StudentCorner\OfferCounter\Domain\OfferCounterRepository;
use StudentCorner\User\Domain\UserId;

final class ShowOfferCounterService
{
    private OfferCounterRepository $repository;

    public function __construct(OfferCounterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserId $userId): OfferCounter
    {
        return $this->repository->findByUserId($userId);
    }
}

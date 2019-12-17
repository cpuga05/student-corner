<?php

declare(strict_types=1);

namespace StudentCorner\OfferCounter\Domain;

use StudentCorner\User\Domain\UserId;

interface OfferCounterRepository
{
    public function save(OfferCounter $offerCounter): void;

    public function findByUserId(UserId $userId): ?OfferCounter;
}

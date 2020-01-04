<?php

declare(strict_types=1);

namespace StudentCorner\OfferCounter\Application\Show;

use Shared\Domain\Bus\Query\QueryHandler;
use StudentCorner\OfferCounter\Application\OfferCounterResponse;
use StudentCorner\User\Domain\UserId;

final class ShowOfferCounterQueryHandler implements QueryHandler
{
    private ShowOfferCounterService $service;

    public function __construct(ShowOfferCounterService $service)
    {
        $this->service = $service;
    }

    public function __invoke(ShowOfferCounterQuery $query): OfferCounterResponse
    {
        $userId = new UserId($query->userId());
        $offerCounter = $this->service->__invoke($userId);

        return OfferCounterResponse::fromOfferCounter($offerCounter);
    }
}

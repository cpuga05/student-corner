<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Application\Show;

use Shared\Domain\Bus\Query\QueryHandler;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\Filters;
use Shared\Domain\Criteria\Order;
use StudentCorner\Offer\Application\OffersResponse;

use function dump;

final class ShowOffersQueryHandler implements QueryHandler
{
    /** @var ShowOffersService */
    private ShowOffersService $service;

    public function __construct(ShowOffersService $service)
    {
        $this->service = $service;
    }

    public function __invoke(ShowOffersQuery $query): OffersResponse
    {
        $criteria = new Criteria(
            Filters::fromValues($query->filters()),
            Order::fromValues($query->orderBy(), $query->order()),
            $query->offset(),
            $query->limit()
        );
        $offers = $this->service->__invoke($criteria);

        return OffersResponse::fromOffers($offers);
    }
}

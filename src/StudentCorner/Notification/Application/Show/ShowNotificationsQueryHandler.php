<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Application\Show;

use Shared\Domain\Bus\Query\QueryHandler;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\Filters;
use Shared\Domain\Criteria\Order;
use StudentCorner\Notification\NotificationsResponse;

final class ShowNotificationsQueryHandler implements QueryHandler
{
    private ShowNotificationsService $service;

    public function __construct(ShowNotificationsService $service)
    {
        $this->service = $service;
    }

    public function __invoke(ShowNotificationsQuery $query): NotificationsResponse
    {
        $criteria = new Criteria(
            Filters::fromValues($query->filters()),
            Order::fromValues($query->orderBy(), $query->order()),
            $query->offset(),
            $query->limit()
        );
        $notifications = $this->service->__invoke($criteria);

        return NotificationsResponse::fromNotifications($notifications);
    }
}

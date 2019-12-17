<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Application\UnreadCounter;

use Shared\Domain\Bus\Query\QueryHandler;
use StudentCorner\Notification\Application\CounterNotificationsResponse;
use StudentCorner\User\Domain\UserId;

final class UnreadCounterNotificationsQueryHandler implements QueryHandler
{
    private UnreadCounterNotificationsService $service;

    public function __construct(UnreadCounterNotificationsService $service)
    {
        $this->service = $service;
    }

    public function __invoke(UnreadCounterNotificationsQuery $query): CounterNotificationsResponse
    {
        $userId = new UserId($query->userId());
        $counter = $this->service->__invoke($userId);

        return new CounterNotificationsResponse($counter);
    }
}

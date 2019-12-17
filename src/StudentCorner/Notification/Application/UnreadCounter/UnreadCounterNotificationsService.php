<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Application\UnreadCounter;

use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\Filters;
use Shared\Domain\Criteria\Order;
use StudentCorner\Notification\Domain\NotificationRepository;
use StudentCorner\Notification\Domain\NotificationStatus;
use StudentCorner\User\Domain\UserId;

use function dump;

final class UnreadCounterNotificationsService
{
    private NotificationRepository $repository;

    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserId $userId): int
    {
        $criteria = new Criteria(
            Filters::fromValues(
                [
                    ['field' => 'userId', 'operator' => '=', 'value' => $userId->value()],
                    ['field' => 'status', 'operator' => '=', 'value' => NotificationStatus::UNREAD],
                ]
            ),
            Order::none(),
            null,
            null
        );

        return $this->repository->matchingCounter($criteria);
    }
}

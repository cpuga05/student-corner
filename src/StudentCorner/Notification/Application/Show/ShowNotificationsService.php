<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Application\Show;

use Shared\Domain\Criteria\Criteria;
use StudentCorner\Notification\Domain\NotificationRepository;
use StudentCorner\Notification\Domain\Notifications;

final class ShowNotificationsService
{
    private NotificationRepository $repository;

    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Criteria $criteria): Notifications
    {
        return $this->repository->matching($criteria);
    }
}

<?php

namespace StudentCorner\Notification\Domain;

use Shared\Domain\Criteria\Criteria;
use StudentCorner\User\Domain\UserId;

interface NotificationRepository
{
    public function save(Notification $notification): void;

    public function findById(NotificationId $id): ?Notification;

    public function findByUser(UserId $userId): Notifications;

    public function matching(Criteria $criteria): Notifications;

    public function matchingCounter(Criteria $criteria): int;
}

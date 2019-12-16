<?php

namespace StudentCorner\Notification\Domain;

use StudentCorner\User\Domain\UserId;

interface NotificationRepository
{
    public function save(Notification $notification): void;

    public function findById(NotificationId $id): ?Notification;

    public function findByUser(UserId $userId): Notifications;
}

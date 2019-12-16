<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Infrastructure;

use Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use StudentCorner\Notification\Domain\Notification;
use StudentCorner\Notification\Domain\NotificationId;
use StudentCorner\Notification\Domain\NotificationRepository;
use StudentCorner\Notification\Domain\Notifications;
use StudentCorner\User\Domain\UserId;

final class DoctrineNotificationRepository extends DoctrineRepository implements NotificationRepository
{
    protected function entity(): String
    {
        return Notification::class;
    }

    public function save(Notification $notification): void
    {
        $this->persist($notification);
    }

    public function findById(NotificationId $id): ?Notification
    {
        return $this->repository()->find($id);
    }

    public function findByUser(UserId $userId): Notifications
    {
        $notifications = $this->repository()->findBy(['userId' => $userId], ['publishedAt' => 'desc']);

        return new Notifications($notifications);
    }
}

<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Infrastructure;

use Shared\Domain\Criteria\Criteria;
use Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
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

    public function matching(Criteria $criteria): Notifications
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);
        $notifications = $this->repository()->matching($doctrineCriteria)->toArray();

        return new Notifications($notifications);
    }

    public function matchingCounter(Criteria $criteria): int
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convertToCount($criteria);

        return $this->repository()->matching($doctrineCriteria)->count();
    }
}

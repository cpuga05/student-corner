<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Application\Read;

use Shared\Domain\Bus\Event\EventBus;
use StudentCorner\Notification\Domain\NotificationId;
use StudentCorner\Notification\Domain\NotificationNotExist;
use StudentCorner\Notification\Domain\NotificationRepository;

final class ReadNotificationService
{
    private NotificationRepository $repository;
    private EventBus $eventBus;

    public function __construct(NotificationRepository $repository, EventBus $eventBus)
    {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(NotificationId $id): void
    {
        $notification = $this->repository->findById($id);

        if (null === $notification) {
            throw new NotificationNotExist($id);
        }

        $notification->read();
        $this->repository->save($notification);
        $this->eventBus->publish(...$notification->pullDomainEvents());
    }
}

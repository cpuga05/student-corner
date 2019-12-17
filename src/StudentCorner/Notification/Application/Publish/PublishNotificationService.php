<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Application\Publish;

use Shared\Domain\Bus\Event\EventBus;
use Shared\Domain\Bus\Query\QueryBus;
use StudentCorner\Notification\Domain\Notification;
use StudentCorner\Notification\Domain\NotificationAlreadyExist;
use StudentCorner\Notification\Domain\NotificationBody;
use StudentCorner\Notification\Domain\NotificationDestination;
use StudentCorner\Notification\Domain\NotificationId;
use StudentCorner\Notification\Domain\NotificationRepository;
use StudentCorner\Notification\Domain\NotificationType;
use StudentCorner\User\Application\View\ViewUserQuery;
use StudentCorner\User\Domain\UserId;

final class PublishNotificationService
{
    /** @var NotificationRepository */
    private NotificationRepository $repository;
    /** @var QueryBus */
    private QueryBus $queryBus;
    /** @var EventBus */
    private EventBus $eventBus;

    public function __construct(NotificationRepository $repository, QueryBus $queryBus, EventBus $eventBus)
    {
        $this->repository = $repository;
        $this->queryBus = $queryBus;
        $this->eventBus = $eventBus;
    }

    public function __invoke(
        NotificationId $id,
        NotificationType $type,
        NotificationDestination $destination,
        NotificationBody $body,
        UserId $userId
    ): void {
        if (null !== $this->repository->findById($id)) {
            throw new NotificationAlreadyExist($id);
        }

        $this->queryBus->ask(new ViewUserQuery($userId->value()));

        $notification = Notification::publish($id, $type, $destination, $body, $userId);

        $this->repository->save($notification);
        $this->eventBus->publish(...$notification->pullDomainEvents());
    }
}

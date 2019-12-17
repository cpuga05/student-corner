<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Application\Publish;

use Shared\Domain\Bus\Command\CommandHandler;
use StudentCorner\Notification\Domain\NotificationBody;
use StudentCorner\Notification\Domain\NotificationDestination;
use StudentCorner\Notification\Domain\NotificationId;
use StudentCorner\Notification\Domain\NotificationType;
use StudentCorner\User\Domain\UserId;

final class PublishNotificationCommandHandler implements CommandHandler
{
    /** @var PublishNotificationService */
    private PublishNotificationService $service;

    public function __construct(PublishNotificationService $service)
    {
        $this->service = $service;
    }

    public function __invoke(PublishNotificationCommand $command): void
    {
        $id = new NotificationId($command->id());
        $type = new NotificationType($command->type());
        $destination = new NotificationDestination($command->destination());
        $body = new NotificationBody($command->body());
        $userId = new UserId($command->userId());

        $this->service->__invoke($id, $type, $destination, $body, $userId);
    }
}

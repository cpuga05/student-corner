<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Application\Read;

use Shared\Domain\Bus\Command\CommandHandler;
use StudentCorner\Notification\Domain\NotificationId;

final class ReadNotificationCommandHandler implements CommandHandler
{
    private ReadNotificationService $service;

    public function __construct(ReadNotificationService $service)
    {
        $this->service = $service;
    }

    public function __invoke(ReadNotificationCommand $command): void
    {
        $id = new NotificationId($command->id());

        $this->service->__invoke($id);
    }
}

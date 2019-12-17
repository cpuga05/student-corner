<?php

declare(strict_types=1);

namespace StudentCorner\Notification;

use Shared\Domain\Bus\Query\Response;
use StudentCorner\Notification\Application\NotificationResponse;
use StudentCorner\Notification\Domain\Notifications;

final class NotificationsResponse implements Response
{
    /** @var NotificationResponse[] */
    private array $notifications;

    public function __construct(NotificationResponse ...$notifications)
    {
        $this->notifications = $notifications;
    }

    public static function fromNotifications(Notifications $notifications): self
    {
        $collection = [];

        foreach ($notifications as $notification) {
            $collection[] = NotificationResponse::fromNotification($notification);
        }

        return new self(...$collection);
    }

    public function notifications(): array
    {
        return $this->notifications;
    }
}

<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Domain;

use DateTimeImmutable;
use Shared\Domain\Aggregate\AggregateRoot;
use StudentCorner\User\Domain\UserId;

final class Notification extends AggregateRoot
{
    /** @var NotificationId */
    private NotificationId $id;
    /** @var NotificationType */
    private NotificationType $type;
    /** @var NotificationDestination */
    private NotificationDestination $destination;
    /** @var NotificationBody */
    private NotificationBody $body;
    /** @var NotificationStatus */
    private NotificationStatus $status;
    /** @var UserId */
    private UserId $userId;
    /** @var DateTimeImmutable */
    private DateTimeImmutable $publishedAt;

    public function __construct(
        NotificationId $id,
        NotificationType $type,
        NotificationDestination $destination,
        NotificationBody $body,
        NotificationStatus $status,
        UserId $userId,
        DateTimeImmutable $publishedAt
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->destination = $destination;
        $this->body = $body;
        $this->status = $status;
        $this->userId = $userId;
        $this->publishedAt = $publishedAt;
    }

    public static function publish(
        NotificationId $id,
        NotificationType $type,
        NotificationDestination $destination,
        NotificationBody $body,
        UserId $userId
    ): self {
        $notification = new self(
            $id,
            $type,
            $destination,
            $body,
            NotificationStatus::fromString(NotificationStatus::UNREAD),
            $userId,
            new DateTimeImmutable()
        );

        $notification->record(NotificationPublished::create($notification));

        return $notification;
    }

    public function read(): void
    {
        if (!$this->status->equals(NotificationStatus::fromString(NotificationStatus::UNREAD))) {
            return;
        }

        $this->status = NotificationStatus::fromString(NotificationStatus::READ);

        $this->record(NotificationRead::create($this));
    }

    public function id(): NotificationId
    {
        return $this->id;
    }

    public function type(): NotificationType
    {
        return $this->type;
    }

    public function destination(): NotificationDestination
    {
        return $this->destination;
    }

    public function body(): NotificationBody
    {
        return $this->body;
    }

    public function status(): NotificationStatus
    {
        return $this->status;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function publishedAt(): DateTimeImmutable
    {
        return $this->publishedAt;
    }
}

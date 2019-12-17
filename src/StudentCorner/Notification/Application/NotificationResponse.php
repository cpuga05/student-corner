<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Application;

use DateTimeImmutable;
use Shared\Domain\Bus\Query\Response;
use StudentCorner\Notification\Domain\Notification;

final class NotificationResponse implements Response
{
    private string $id;
    private string $type;
    private string $destination;
    private string $body;
    private string $status;
    private string $userId;
    private DateTimeImmutable $publishedAt;

    public function __construct(
        string $id,
        string $type,
        string $destination,
        string $body,
        string $status,
        string $userId,
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

    public static function fromNotification(Notification $notification): self
    {
        return new self(
            $notification->id()->value(),
            $notification->type()->value(),
            $notification->destination()->value(),
            $notification->body()->value(),
            $notification->status()->value(),
            $notification->userId()->value(),
            $notification->publishedAt()
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function destination(): string
    {
        return $this->destination;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function publishedAt(): string
    {
        return $this->publishedAt;
    }
}

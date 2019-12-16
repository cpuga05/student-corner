<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Domain;

use Shared\Domain\Bus\Event\DomainEvent;
use Shared\Domain\Utils;

final class NotificationPublished extends DomainEvent
{
    /** @var string */
    private $type;
    /** @var string */
    private $destination;
    /** @var string */
    private $body;
    /** @var string */
    private $status;
    /** @var string */
    private $userId;
    /** @var string */
    private $publishedAt;

    public function __construct(
        string $aggregateId,
        string $type,
        string $destination,
        string $body,
        string $status,
        string $userId,
        string $publishedAt,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($aggregateId, $eventId, $occurredOn);
        $this->type = $type;
        $this->destination = $destination;
        $this->body = $body;
        $this->status = $status;
        $this->userId = $userId;
        $this->publishedAt = $publishedAt;
    }

    public static function create(Notification $notification): self
    {
        return new self(
            $notification->id()->value(),
            $notification->type()->value(),
            $notification->destination()->value(),
            $notification->body()->value(),
            $notification->status()->value(),
            $notification->userId()->value(),
            Utils::dateToString($notification->publishedAt())
        );
    }

    public function eventName(): string
    {
        return 'notification.published';
    }

    public function toPrimitives(): array
    {
        return [
            'type' => $this->type,
            'destination' => $this->destination,
            'body' => $this->body,
            'status' => $this->status,
            'user_id' => $this->userId,
            'published_at' => $this->publishedAt,
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self(
            $aggregateId,
            $body['type'],
            $body['destination'],
            $body['body'],
            $body['status'],
            $body['user_id'],
            $body['published_at'],
            $eventId,
            $occurredOn
        );
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

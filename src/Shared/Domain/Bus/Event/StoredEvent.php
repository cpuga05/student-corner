<?php

declare(strict_types=1);

namespace Shared\Domain\Bus\Event;

use DateTimeImmutable;

final class StoredEvent
{
    /** @var int */
    private $id;
    private string $eventId;
    private string $aggregateId;
    private string $name;
    private array $body;
    private DateTimeImmutable $occurredOn;

    public function __construct(
        string $eventId,
        string $aggregateId,
        string $name,
        array $body,
        DateTimeImmutable $occurredOn
    ) {
        $this->eventId = $eventId;
        $this->aggregateId = $aggregateId;
        $this->name = $name;
        $this->body = $body;
        $this->occurredOn = $occurredOn;
    }

    public static function fromDomainEvent(DomainEvent $domainEvent): self
    {
        return new self(
            $domainEvent->eventId(),
            $domainEvent->aggregateId(),
            $domainEvent::eventName(),
            $domainEvent->toPrimitives(),
            new DateTimeImmutable($domainEvent->occurredOn())
        );
    }

    public function id(): int
    {
        return $this->id;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function body(): array
    {
        return $this->body;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}

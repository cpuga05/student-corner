<?php

declare(strict_types=1);

namespace Shared\Domain\Bus\Event;

use DateTimeImmutable;
use Shared\Domain\Utils;
use Shared\Domain\ValueObject\Uuid;

abstract class DomainEvent
{
    /** @var string */
    private $aggregateId;
    /** @var string */
    private $eventId;
    /** @var string */
    private $occurredOn;

    public function __construct(string $aggregateId, string $eventId = null, string $occurredOn = null)
    {
        $this->aggregateId = $aggregateId;
        $this->eventId = $eventId ?: Uuid::random()->value();
        $this->occurredOn = $occurredOn ?: Utils::dateToString(new DateTimeImmutable());
    }

    abstract public function eventName(): string;

    abstract public function toPrimitives(): array;

    abstract public static function fromPrimitives(string $aggregateId, array $body, string $eventId, string $occurredOn): self;

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}

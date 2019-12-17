<?php

declare(strict_types=1);

namespace StudentCorner\OfferCounter\Domain;

use Shared\Domain\Bus\Event\DomainEvent;

final class OfferCounterIncremented extends DomainEvent
{
    private int $total;

    public function __construct(string $aggregateId, int $total, string $eventId = null, string $occurredOn = null)
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
        $this->total = $total;
    }

    public static function create(OfferCounter $offerCounter): self
    {
        return new self($offerCounter->userId()->value(), $offerCounter->total()->value());
    }

    public function eventName(): string
    {
        return 'offer_counter.incremented';
    }

    public function toPrimitives(): array
    {
        return [
            'total' => $this->total,
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, $body['total'], $eventId, $occurredOn);
    }

    public function total(): int
    {
        return $this->total;
    }
}

<?php

declare(strict_types=1);

namespace StudentCorner\Score\Domain;

use Shared\Domain\Bus\Event\DomainEvent;

final class ScoreDecreased extends DomainEvent
{
    /** @var int */
    private int $point;

    public function __construct(string $aggregateId, int $point, string $eventId = null, string $occurredOn = null)
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
        $this->point = $point;
    }

    public static function create(Score $score): self
    {
        return new self($score->userId()->value(), $score->point()->value());
    }

    public function eventName(): string
    {
        return 'score.decreased';
    }

    public function toPrimitives(): array
    {
        return [
            'point' => $this->point,
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, $body['point'], $eventId, $occurredOn);
    }

    public function point(): int
    {
        return $this->point;
    }
}

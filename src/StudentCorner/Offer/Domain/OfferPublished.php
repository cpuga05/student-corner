<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Domain;

use Shared\Domain\Bus\Event\DomainEvent;

final class OfferPublished extends DomainEvent
{
    /** @var string */
    private $name;
    /** @var string */
    private $school;
    /** @var string */
    private $course;
    /** @var string */
    private $teacher;
    /** @var int */
    private $price;
    /** @var string */
    private $userId;

    public function __construct(
        string $aggregateId,
        string $name,
        string $school,
        string $course,
        string $teacher,
        int $price,
        string $userId,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($aggregateId, $eventId, $occurredOn);
        $this->name = $name;
        $this->school = $school;
        $this->course = $course;
        $this->teacher = $teacher;
        $this->price = $price;
        $this->userId = $userId;
    }

    public static function create(Offer $offer): self
    {
        return new self(
            $offer->id()->value(),
            $offer->name()->value(),
            $offer->school()->value(),
            $offer->course()->value(),
            $offer->teacher()->value(),
            $offer->price()->value(),
            $offer->userId()->value()
        );
    }

    public function eventName(): string
    {
        return 'offer.created';
    }

    public function toPrimitives(): array
    {
        return [
            'name' => $this->name,
            'school' => $this->school,
            'course' => $this->course,
            'teacher' => $this->teacher,
            'price' => $this->price,
            'user_id' => $this->userId,
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
            $body['name'],
            $body['school'],
            $body['course'],
            $body['teacher'],
            $body['price'],
            $body['user_id'],
            $eventId,
            $occurredOn
        );
    }

    public function name(): string
    {
        return $this->name;
    }

    public function school(): string
    {
        return $this->school;
    }

    public function course(): string
    {
        return $this->course;
    }

    public function teacher(): string
    {
        return $this->teacher;
    }

    public function price(): int
    {
        return $this->price;
    }

    public function userId(): string
    {
        return $this->userId;
    }
}

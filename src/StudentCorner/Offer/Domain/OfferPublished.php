<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Domain;

use Shared\Domain\Bus\Event\DomainEvent;
use Shared\Domain\Utils;

final class OfferPublished extends DomainEvent
{
    private string $name;
    private string $school;
    private string $course;
    private string $teacher;
    private int $price;
    private string $userId;
    private string $publishedAt;

    public function __construct(
        string $aggregateId,
        string $name,
        string $school,
        string $course,
        string $teacher,
        int $price,
        string $userId,
        string $publishedAt,
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
        $this->publishedAt = $publishedAt;
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
            $offer->userId()->value(),
            Utils::dateToString($offer->publishedAt())
        );
    }

    public function eventName(): string
    {
        return 'offer.published';
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

    public function publishedAt(): string
    {
        return $this->publishedAt;
    }
}

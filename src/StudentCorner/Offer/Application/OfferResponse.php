<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Application;

use DateTimeImmutable;
use Shared\Domain\Bus\Query\Response;
use StudentCorner\Offer\Domain\Offer;

final class OfferResponse implements Response
{
    /** @var string */
    private string $id;
    /** @var string */
    private string $name;
    /** @var string */
    private string $school;
    /** @var string */
    private string $course;
    /** @var string */
    private string $teacher;
    /** @var int */
    private int $price;
    /** @var string */
    private string $userId;
    /** @var DateTimeImmutable */
    private DateTimeImmutable $publishedAt;

    public function __construct(
        string $id,
        string $name,
        string $school,
        string $course,
        string $teacher,
        int $price,
        string $userId,
        DateTimeImmutable $publishedAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->school = $school;
        $this->course = $course;
        $this->teacher = $teacher;
        $this->price = $price;
        $this->userId = $userId;
        $this->publishedAt = $publishedAt;
    }

    public static function fromOffer(Offer $offer): self
    {
        return new self(
            $offer->id()->value(),
            $offer->name()->value(),
            $offer->school()->value(),
            $offer->course()->value(),
            $offer->teacher()->value(),
            $offer->price()->value(),
            $offer->userId()->value(),
            $offer->publishedAt()
        );
    }

    public function id(): string
    {
        return $this->id;
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

    public function publishedAt(): DateTimeImmutable
    {
        return $this->publishedAt;
    }
}

<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Domain;

use DateTimeImmutable;
use Shared\Domain\Aggregate\AggregateRoot;
use StudentCorner\User\Domain\UserId;

final class Offer extends AggregateRoot
{
    /** @var OfferId */
    private OfferId $id;
    /** @var OfferName */
    private OfferName $name;
    /** @var OfferSchool */
    private OfferSchool $school;
    /** @var OfferCourse */
    private OfferCourse $course;
    /** @var OfferTeacher */
    private OfferTeacher $teacher;
    /** @var OfferPrice */
    private OfferPrice $price;
    /** @var UserId */
    private UserId $userId;
    /** @var DateTimeImmutable */
    private DateTimeImmutable $publishedAt;

    public function __construct(
        OfferId $id,
        OfferName $name,
        OfferSchool $school,
        OfferCourse $course,
        OfferTeacher $teacher,
        OfferPrice $price,
        UserId $userId,
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

    public static function publish(
        OfferId $id,
        OfferName $name,
        OfferSchool $school,
        OfferCourse $course,
        OfferTeacher $teacher,
        OfferPrice $price,
        UserId $userId
    ): self {
        $offer = new self($id, $name, $school, $course, $teacher, $price, $userId, new DateTimeImmutable());

        $offer->record(OfferPublished::create($offer));

        return $offer;
    }

    public function id(): OfferId
    {
        return $this->id;
    }

    public function name(): OfferName
    {
        return $this->name;
    }

    public function school(): OfferSchool
    {
        return $this->school;
    }

    public function course(): OfferCourse
    {
        return $this->course;
    }

    public function teacher(): OfferTeacher
    {
        return $this->teacher;
    }

    public function price(): OfferPrice
    {
        return $this->price;
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

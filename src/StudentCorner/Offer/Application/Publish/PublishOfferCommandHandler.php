<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Application\Publish;

use Shared\Domain\Bus\Command\CommandHandler;
use StudentCorner\Offer\Domain\OfferCourse;
use StudentCorner\Offer\Domain\OfferId;
use StudentCorner\Offer\Domain\OfferName;
use StudentCorner\Offer\Domain\OfferPrice;
use StudentCorner\Offer\Domain\OfferSchool;
use StudentCorner\Offer\Domain\OfferTeacher;
use StudentCorner\User\Domain\UserId;

final class PublishOfferCommandHandler implements CommandHandler
{
    /** @var PublishOfferService */
    private PublishOfferService $service;

    public function __construct(PublishOfferService $service)
    {
        $this->service = $service;
    }

    public function __invoke(PublishOfferCommand $command): void
    {
        $id = new OfferId($command->id());
        $name = new OfferName($command->name());
        $school = new OfferSchool($command->school());
        $course = new OfferCourse($command->course());
        $teacher = new OfferTeacher($command->teacher());
        $price = new OfferPrice($command->price());
        $userId = new UserId($command->userId());

        $this->service->__invoke($id, $name, $school, $course, $teacher, $price, $userId);
    }
}

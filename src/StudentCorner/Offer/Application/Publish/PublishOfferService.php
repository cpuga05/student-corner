<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Application\Publish;

use Shared\Domain\Bus\Event\EventBus;
use Shared\Domain\Bus\Query\QueryBus;
use StudentCorner\Offer\Domain\Offer;
use StudentCorner\Offer\Domain\OfferAlreadyExist;
use StudentCorner\Offer\Domain\OfferCourse;
use StudentCorner\Offer\Domain\OfferId;
use StudentCorner\Offer\Domain\OfferName;
use StudentCorner\Offer\Domain\OfferPrice;
use StudentCorner\Offer\Domain\OfferRepository;
use StudentCorner\Offer\Domain\OfferSchool;
use StudentCorner\Offer\Domain\OfferTeacher;
use StudentCorner\User\Application\View\ViewUserQuery;
use StudentCorner\User\Domain\UserId;

final class PublishOfferService
{
    private OfferRepository $repository;
    private QueryBus $queryBus;
    private EventBus $eventBus;

    public function __construct(OfferRepository $repository, QueryBus $queryBus, EventBus $eventBus)
    {
        $this->repository = $repository;
        $this->queryBus = $queryBus;
        $this->eventBus = $eventBus;
    }

    public function __invoke(
        OfferId $id,
        OfferName $name,
        OfferSchool $school,
        OfferCourse $course,
        OfferTeacher $teacher,
        OfferPrice $price,
        UserId $userId
    ): void {
        if (null !== $this->repository->findById($id)) {
            throw new OfferAlreadyExist($id);
        }

        $this->queryBus->ask(new ViewUserQuery($userId->value()));

        $offer = Offer::publish($id, $name, $school, $course, $teacher, $price, $userId);

        $this->repository->save($offer);
        $this->eventBus->publish(...$offer->pullDomainEvents());
    }
}

<?php

declare(strict_types=1);

namespace StudentCorner\Score\Application\Increase;

use Shared\Domain\Bus\Event\DomainEventSubscriber;
use StudentCorner\Offer\Domain\OfferPublished;
use StudentCorner\Score\Domain\ScorePoint;
use StudentCorner\User\Domain\UserId;

final class IncreaseScoreOnOfferPublished implements DomainEventSubscriber
{
    /** @var IncreaseScoreService */
    private $service;

    public function __construct(IncreaseScoreService $service)
    {
        $this->service = $service;
    }

    public static function subscribedTo(): array
    {
        return [OfferPublished::class];
    }

    public function __invoke(OfferPublished $offerPublished): void
    {
        $userId = new UserId($offerPublished->userId());
        $point = new ScorePoint(5);

        $this->service->__invoke($userId, $point);
    }
}

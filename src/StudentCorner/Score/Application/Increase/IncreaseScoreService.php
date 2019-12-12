<?php

declare(strict_types=1);

namespace StudentCorner\Score\Application\Increase;

use Shared\Domain\Bus\Event\EventBus;
use StudentCorner\Score\Domain\Score;
use StudentCorner\Score\Domain\ScorePoint;
use StudentCorner\Score\Domain\ScoreRepository;
use StudentCorner\User\Domain\UserId;

final class IncreaseScoreService
{
    /** @var ScoreRepository */
    private $repository;
    /** @var EventBus */
    private $eventBus;

    public function __construct(ScoreRepository $repository, EventBus $eventBus)
    {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(UserId $userId, ScorePoint $point): void
    {
        $score = $this->repository->findByUserId($userId);

        if (null === $score) {
            $score = Score::crate($userId);
        }

        $score->increase($point);
        $this->repository->save($score);
        $this->eventBus->publish(...$score->pullDomainEvents());
    }
}

<?php

declare(strict_types=1);

namespace StudentCorner\Score\Application\Show;

use StudentCorner\Score\Domain\Score;
use StudentCorner\Score\Domain\ScoreRepository;
use StudentCorner\User\Domain\UserId;

final class ShowScoreService
{
    /** @var ScoreRepository */
    private ScoreRepository $repository;

    public function __construct(ScoreRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserId $userId): Score
    {
        $score = $this->repository->findByUserId($userId);

        if (null === $score) {
            $score = Score::create($userId);
        }

        return $score;
    }
}

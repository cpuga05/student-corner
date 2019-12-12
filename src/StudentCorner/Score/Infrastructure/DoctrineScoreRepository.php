<?php

declare(strict_types=1);

namespace StudentCorner\Score\Infrastructure;

use Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use StudentCorner\Score\Domain\Score;
use StudentCorner\Score\Domain\ScoreRepository;
use StudentCorner\User\Domain\UserId;

final class DoctrineScoreRepository extends DoctrineRepository implements ScoreRepository
{
    protected function entity(): String
    {
        return Score::class;
    }

    public function save(Score $score): void
    {
        $this->persist($score);
    }

    public function findByUserId(UserId $userId): ?Score
    {
        return $this->repository()->find($userId);
    }
}

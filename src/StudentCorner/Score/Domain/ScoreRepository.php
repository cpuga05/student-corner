<?php

declare(strict_types=1);

namespace StudentCorner\Score\Domain;

use StudentCorner\User\Domain\UserId;

interface ScoreRepository
{
    public function save(Score $score): void;

    public function findByUserId(UserId $userId): ?Score;
}

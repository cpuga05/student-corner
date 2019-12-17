<?php

declare(strict_types=1);

namespace StudentCorner\Score\Domain;

use Shared\Domain\Aggregate\AggregateRoot;
use StudentCorner\User\Domain\UserId;

final class Score extends AggregateRoot
{
    private UserId $userId;
    private ScorePoint $point;

    public function __construct(UserId $userId, ScorePoint $point)
    {
        $this->userId = $userId;
        $this->point = $point;
    }

    public static function create(UserId $userId): self
    {
        $score = new self($userId, ScorePoint::zero());

        $score->record(ScoreCreated::create($score));

        return $score;
    }

    public function increase(ScorePoint $point): void
    {
        $this->point = $this->point->add($point);

        $this->record(ScoreIncreased::create($this));
    }

    public function decrease(ScorePoint $point): void
    {
        $this->point = $this->point->subtract($point);

        $this->record(ScoreDecreased::create($this));
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function point(): ScorePoint
    {
        return $this->point;
    }
}

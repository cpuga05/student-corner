<?php

declare(strict_types=1);

namespace StudentCorner\Score\Domain;

use Shared\Domain\Aggregate\AggregateRoot;
use StudentCorner\User\Domain\UserId;

final class Score extends AggregateRoot
{
    /** @var UserId */
    private $userId;
    /** @var ScorePoint */
    private $point;

    public function __construct(UserId $userId, ScorePoint $point)
    {
        $this->userId = $userId;
        $this->point = $point;
    }

    public static function crate(UserId $userId): self
    {
        return new self($userId, ScorePoint::zero());
    }

    public function increase(ScorePoint $point): void
    {
        $this->point = $this->point->add($point);
    }

    public function decrease(ScorePoint $point): void
    {
        $this->point = $this->point->subtract($point);
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

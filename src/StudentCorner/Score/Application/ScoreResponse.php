<?php

declare(strict_types=1);

namespace StudentCorner\Score\Application;

use Shared\Domain\Bus\Query\Response;
use StudentCorner\Score\Domain\Score;

final class ScoreResponse implements Response
{
    /** @var string */
    private string $userId;
    /** @var int */
    private int $point;

    public function __construct(string $userId, int $point)
    {
        $this->userId = $userId;
        $this->point = $point;
    }

    public static function fromScore(Score $score): self
    {
        return new self($score->userId()->value(), $score->point()->value());
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function point(): int
    {
        return $this->point;
    }
}

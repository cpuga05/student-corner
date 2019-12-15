<?php

declare(strict_types=1);

namespace StudentCorner\Score\Application\Show;

use Shared\Domain\Bus\Query\Query;

final class ShowScoreQuery implements Query
{
    /** @var string */
    private $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function userId(): string
    {
        return $this->userId;
    }
}

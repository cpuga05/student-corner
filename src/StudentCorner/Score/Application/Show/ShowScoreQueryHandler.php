<?php

declare(strict_types=1);

namespace StudentCorner\Score\Application\Show;

use Shared\Domain\Bus\Query\QueryHandler;
use StudentCorner\Score\Application\ScoreResponse;
use StudentCorner\User\Domain\UserId;

final class ShowScoreQueryHandler implements QueryHandler
{
    /** @var ShowScoreService */
    private ShowScoreService $service;

    public function __construct(ShowScoreService $service)
    {
        $this->service = $service;
    }

    public function __invoke(ShowScoreQuery $query): ScoreResponse
    {
        $userId = new UserId($query->userId());
        $score = $this->service->__invoke($userId);

        return ScoreResponse::fromScore($score);
    }
}

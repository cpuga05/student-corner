<?php

declare(strict_types=1);

namespace StudentCorner\OfferCounter\Application;

use Shared\Domain\Bus\Query\Response;
use StudentCorner\OfferCounter\Domain\OfferCounter;

final class OfferCounterResponse implements Response
{
    private string $userId;
    private int $total;

    public function __construct(string $userId, int $total)
    {
        $this->userId = $userId;
        $this->total = $total;
    }

    public static function fromOfferCounter(OfferCounter $offerCounter): self
    {
        return new self($offerCounter->userId()->value(), $offerCounter->total()->value());
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function total(): int
    {
        return $this->total;
    }
}

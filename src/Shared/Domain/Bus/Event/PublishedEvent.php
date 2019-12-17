<?php

declare(strict_types=1);

namespace Shared\Domain\Bus\Event;

final class PublishedEvent
{
    /** @var string */
    private string $channel;
    /** @var int */
    private int $lastEventPublishedId;

    public function __construct(string $channel, int $lastEventPublishedId)
    {
        $this->channel = $channel;
        $this->lastEventPublishedId = $lastEventPublishedId;
    }

    public function updateLastEventPublishedId(int $lasEventPublishedId): void
    {
        $this->lastEventPublishedId = $lasEventPublishedId;
    }

    public function channel(): string
    {
        return $this->channel;
    }

    public function lastEventPublishedId(): int
    {
        return $this->lastEventPublishedId;
    }
}

<?php

declare(strict_types=1);

namespace Shared\Domain\Bus\Event;

final class PublishedEvent
{
    /** @var string */
    private $channel;
    /** @var int */
    private $lastEventPublishedId;

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

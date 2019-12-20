<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Event;

use Shared\Domain\Bus\Event\StoredEvent;
use Shared\Domain\Utils;
use function array_merge;
use function json_encode;

final class DomainEventJsonSerializer
{
    public static function serialize(StoredEvent $storedEvent): string
    {
        return json_encode(
            [
                'data' => [
                    'id' => $storedEvent->eventId(),
                    'type' => $storedEvent->name(),
                    'occurred_on' => Utils::dateToString($storedEvent->occurredOn()),
                    'attributes' => array_merge($storedEvent->body(), ['id' => $storedEvent->aggregateId()]),
                ],
                'meta' => [],
            ]
        );
    }
}

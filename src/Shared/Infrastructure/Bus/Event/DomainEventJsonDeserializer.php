<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Event;

use Shared\Domain\Bus\Event\DomainEvent;
use Shared\Domain\Bus\Event\DomainEventConsumer;
use function Lambdish\Phunctional\search;

final class DomainEventJsonDeserializer
{
    public static function deserialize(
        DomainEventConsumer $domainEventConsumer,
        string $domainEvent
    ): DomainEvent {
        $eventData = json_decode($domainEvent, true);
        $eventClass = search(
            static function (string $classEvent) use
            (
                $eventData
            ) {
                return $classEvent::eventName() === $eventData['data']['type'];
            },
            $domainEventConsumer::subscribedTo()
        );

        return $eventClass::fromPrimitives(
            $eventData['data']['attributes']['id'],
            $eventData['data']['attributes'],
            $eventData['data']['id'],
            $eventData['data']['occurred_on']
        );
    }
}

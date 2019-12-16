<?php

declare(strict_types=1);

namespace Shared\Application\Event\Logger;

use Exception;
use Shared\Domain\Bus\Event\DomainEvent;
use Shared\Domain\Bus\Event\DomainEventSubscriber;
use Shared\Domain\Logger;

use function get_class;
use function strrpos;
use function substr;

final class LogOnDomainEventOccurred implements DomainEventSubscriber
{
    /** @var Logger */
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public static function subscribedTo(): array
    {
        return [DomainEvent::class];
    }

    public function __invoke(DomainEvent $event)
    {
        $eventClass = get_class($event);
        $eventName = substr($eventClass, strrpos($eventClass, '\\') + 1);

        try {
            $this->logger->info(
                $eventName,
                [
                    'eventId' => $event->eventId(),
                    'aggregateId' => $event->aggregateId(),
                    'name' => $event->eventName(),
                    'body' => $event->toPrimitives(),
                    'occurredOn' => $event->occurredOn(),
                ]
            );
        } catch (Exception $e) {
        }
    }
}

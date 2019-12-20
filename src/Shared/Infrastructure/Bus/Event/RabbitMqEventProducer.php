<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Event;

use Shared\Domain\Bus\Event\EventProducer;
use Shared\Domain\Bus\Event\StoredEvent;
use Shared\Infrastructure\Queue\RabbitMq\RabbitMqConnection;

use function dump;

use const AMQP_NOPARAM;

final class RabbitMqEventProducer implements EventProducer
{
    private RabbitMqConnection $connection;
    private string $exchange;

    public function __construct(RabbitMqConnection $connection)
    {
        $this->connection = $connection;
    }

    public function open(string $channel): void
    {
        $this->exchange = $channel;
    }

    public function send(StoredEvent $storedEvent): void
    {
        $body = DomainEventJsonSerializer::serialize($storedEvent);
        $routingKey = $storedEvent->name();
        $messageId = $storedEvent->eventId();

        dump($routingKey);
        $this->connection->exchange($this->exchange)->publish(
            $body,
            $routingKey,
            AMQP_NOPARAM,
            [
                'message_id' => $messageId,
                'content-type' => 'application/json',
                'encoding' => 'utf-8',
            ]
        );
    }

    public function close(string $channel): void
    {
    }
}

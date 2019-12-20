<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Event;

use AMQPEnvelope;
use AMQPException;
use AMQPQueue;
use Shared\Domain\Bus\Event\DomainEventConsumer;
use Shared\Domain\Bus\Event\EventConsumer;
use Shared\Infrastructure\Queue\RabbitMq\RabbitMqConnection;
use Shared\Infrastructure\Queue\RabbitMq\RabbitMqExchangeNameFormatter;
use Throwable;

use function Lambdish\Phunctional\assoc;
use function Lambdish\Phunctional\get;

use const AMQP_NOPARAM;

final class RabbitMqEventConsumer implements EventConsumer
{
    private RabbitMqConnection $connection;
    private string $exchangeName;
    private int $maxRetries;
    private DomainEventConsumerLocator $locator;

    public function __construct(
        RabbitMqConnection $connection,
        string $exchangeName,
        int $maxRetries,
        DomainEventConsumerLocator $locator
    ) {
        $this->connection = $connection;
        $this->exchangeName = $exchangeName;
        $this->maxRetries = $maxRetries;
        $this->locator = $locator;
    }

    public function consume(string $queueName): void
    {
        $domainEventConsumer = $this->locator->withRabbitMqQueueNamed($queueName);

        try {
            $this->connection->queue($queueName)->consume($this->consumer($domainEventConsumer));
        } catch (AMQPException $e) {
        }
    }

    private function consumer(DomainEventConsumer $domainEventConsumer): callable
    {
        return function (AMQPEnvelope $envelope, AMQPQueue $queue) use ($domainEventConsumer) {
            $domainEvent = DomainEventJsonDeserializer::deserialize($domainEventConsumer, $envelope->getBody());

            try {
                $domainEventConsumer->__invoke($domainEvent);
            } catch (Throwable $throwable) {
                $this->handleConsumptionError($envelope, $queue);

                throw $throwable;
            }

            $queue->ack($envelope->getDeliveryTag());

            return false;
        };
    }

    private function handleConsumptionError(AMQPEnvelope $envelope, AMQPQueue $queue): void
    {
        $this->hasBeenRedeliveredTooMuch($envelope)
            ? $this->sendToDeadLetter($envelope, $queue)
            : $this->sendToRetry($envelope, $queue);

        $queue->ack($envelope->getDeliveryTag());
    }

    private function hasBeenRedeliveredTooMuch(AMQPEnvelope $envelope): bool
    {
        return get('redelivery_count', $envelope->getHeaders(), 0) >= $this->maxRetries;
    }

    private function sendToDeadLetter(
        AMQPEnvelope $envelope,
        AMQPQueue $queue
    ): void {
        $this->sendMessageTo(RabbitMqExchangeNameFormatter::deadLetter($this->exchangeName), $envelope, $queue);
    }

    private function sendToRetry(
        AMQPEnvelope $envelope,
        AMQPQueue $queue
    ): void {
        $this->sendMessageTo(RabbitMqExchangeNameFormatter::retry($this->exchangeName), $envelope, $queue);
    }

    private function sendMessageTo(string $exchangeName, AMQPEnvelope $envelope, AMQPQueue $queue): void
    {
        $headers = $envelope->getHeaders();

        $this->connection->exchange($exchangeName)->publish(
            $envelope->getBody(),
            $queue->getName(),
            AMQP_NOPARAM,
            [
                'message_id' => $envelope->getMessageId(),
                'content_type' => $envelope->getContentType(),
                'content_encoding' => $envelope->getContentEncoding(),
                'priority' => $envelope->getPriority(),
                'headers' => assoc($headers, 'redelivery_count', get('redelivery_count', $headers, 0) + 1),
            ]
        );
    }
}

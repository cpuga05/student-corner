<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Queue\RabbitMq;

use AMQPQueue;
use Shared\Domain\Bus\Event\DomainEvent;
use Shared\Domain\Bus\Event\DomainEventConsumer;
use Shared\Domain\Bus\Event\DomainEventSubscriber;

use function Lambdish\Phunctional\each;

use const AMQP_DURABLE;
use const AMQP_EX_TYPE_TOPIC;

final class RabbitMqConfigurator
{
    private RabbitMqConnection $connection;

    public function __construct(RabbitMqConnection $connection)
    {
        $this->connection = $connection;
    }

    public function configure(string $exchangeName, DomainEventConsumer ...$domainEventSubscribers): void
    {
        $retryExchangeName = RabbitMqExchangeNameFormatter::retry($exchangeName);
        $deadLetterExchangeName = RabbitMqExchangeNameFormatter::deadLetter($exchangeName);

        $this->declareExchange($exchangeName);
        $this->declareExchange($retryExchangeName);
        $this->declareExchange($deadLetterExchangeName);

        $this->declareQueues($exchangeName, $retryExchangeName, $deadLetterExchangeName, ...$domainEventSubscribers);
    }

    private function declareExchange(string $exchangeName): void
    {
        $exchange = $this->connection->exchange($exchangeName);

        $exchange->setType(AMQP_EX_TYPE_TOPIC);
        $exchange->setFlags(AMQP_DURABLE);
        $exchange->declareExchange();
    }

    private function declareQueues(
        string $exchangeName,
        string $retryExchangeName,
        string $deadLetterExchangeName,
        DomainEventConsumer ...$domainEventSubscribers
    ): void {
        each(
            $this->queueDeclarator($exchangeName, $retryExchangeName, $deadLetterExchangeName),
            $domainEventSubscribers
        );
    }

    private function queueDeclarator(
        string $exchangeName,
        string $retryExchangeName,
        string $deadLetterExchangeName
    ): callable {
        return function (DomainEventConsumer $domainEventSubscriber) use (
            $exchangeName,
            $retryExchangeName,
            $deadLetterExchangeName
        ): void {
            $queueName = RabbitMqQueueNameFormatter::format($domainEventSubscriber);
            $retryQueueName = RabbitMqQueueNameFormatter::formatRetry($domainEventSubscriber);
            $deadLetterQueueName = RabbitMqQueueNameFormatter::formatDeadLetter($domainEventSubscriber);

            $queue = $this->declareQueue($queueName);
            $retryQueue = $this->declareQueue($retryQueueName, $exchangeName, $queueName, 1000);
            $deadLetterQueue = $this->declareQueue($deadLetterQueueName);

            $queue->bind($exchangeName, $queueName);
            $retryQueue->bind($retryExchangeName, $queueName);
            $deadLetterQueue->bind($deadLetterExchangeName, $queueName);

            /** @var DomainEvent $eventClass */
            foreach ($domainEventSubscriber::subscribedTo() as $eventClass) {
                if ($eventClass === DomainEvent::class) {
                    continue;
                }

                $queue->bind($exchangeName, $eventClass::eventName());
            }
        };
    }

    private function declareQueue(
        string $queueName,
        string $deadLetterExchange = null,
        string $deadLetterRoutingKey = null,
        int $messageTtl = null
    ): AMQPQueue {
        $queue = $this->connection->queue($queueName);

        if (null !== $deadLetterExchange) {
            $queue->setArgument('x-dead-letter-exchange', $deadLetterExchange);
        }

        if (null !== $deadLetterRoutingKey) {
            $queue->setArgument('x-dead-letter-routing-key', $deadLetterRoutingKey);
        }

        if (null !== $messageTtl) {
            $queue->setArgument('x-message-ttl', $messageTtl);
        }

        $queue->setFlags(AMQP_DURABLE);
        $queue->declareQueue();

        return $queue;
    }
}

<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Event;

use RuntimeException;
use Shared\Domain\Bus\Event\DomainEventConsumer;
use Shared\Infrastructure\Queue\RabbitMq\RabbitMqQueueNameFormatter;
use Traversable;

use function iterator_to_array;
use function Lambdish\Phunctional\search;

final class DomainEventConsumerLocator
{
    private array $mapping;
    private array $rabbitMq;

    public function __construct(Traversable $mapping)
    {
        $this->mapping = iterator_to_array($mapping);
    }

    public function withRabbitMqQueueNamed(string $queueName): DomainEventConsumer
    {
        if (isset($this->rabbitMq[$queueName])) {
            return $this->rabbitMq[$queueName];
        }

        $subscriber = search(
            fn(DomainEventConsumer $subscriber) => RabbitMqQueueNameFormatter::format($subscriber) === $queueName,
            $this->mapping
        );

        if (null === $subscriber) {
            throw new RuntimeException("There are no subscribers for the <$queueName> queue");
        }

        $this->rabbitMq[$queueName] = $subscriber;

        return $subscriber;
    }

    public function all(): array
    {
        return $this->mapping;
    }
}

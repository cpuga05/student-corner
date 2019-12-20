<?php

declare(strict_types=1);

namespace Shared\Application\Event\Consume;

use Shared\Domain\Bus\Event\EventConsumer;

use function Lambdish\Phunctional\repeat;

final class ConsumeEventsService
{
    private EventConsumer $consumer;

    public function __construct(EventConsumer $consumer)
    {
        $this->consumer = $consumer;
    }

    public function __invoke(string $queueName, int $quantity): void
    {
        repeat(fn() => $this->consumer->consume($queueName), $quantity);
    }
}

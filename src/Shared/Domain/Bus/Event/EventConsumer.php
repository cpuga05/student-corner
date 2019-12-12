<?php

declare(strict_types=1);

namespace Shared\Domain\Bus\Event;

interface EventConsumer
{
    public function consume(string $queueName): void;
}

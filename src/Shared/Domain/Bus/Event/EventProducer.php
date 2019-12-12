<?php

declare(strict_types=1);

namespace Shared\Domain\Bus\Event;

interface EventProducer
{
    public function open(string $channel): void;

    public function send(StoredEvent $storedEvent): void;

    public function close(string $channel): void;
}

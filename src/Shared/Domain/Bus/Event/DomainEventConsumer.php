<?php

namespace Shared\Domain\Bus\Event;

interface DomainEventConsumer
{
    public static function subscribedTo(): array;
}

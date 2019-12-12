<?php

declare(strict_types=1);

namespace Shared\Domain\Aggregate;

use Shared\Domain\Bus\Event\DomainEvent;

abstract class AggregateRoot
{
    /** @var array */
    private $domainEvents = [];

    final protected function record(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }

    final public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }
}

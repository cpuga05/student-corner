<?php

declare(strict_types=1);

namespace Shared\Domain\Bus\Event;

use Shared\Domain\Collection;

final class StoredEvents extends Collection
{
    protected function type(): string
    {
        return StoredEvent::class;
    }
}

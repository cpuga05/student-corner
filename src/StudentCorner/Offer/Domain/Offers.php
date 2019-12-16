<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Domain;

use Shared\Domain\Collection;

final class Offers extends Collection
{
    protected function type(): string
    {
        return Offer::class;
    }
}

<?php

declare(strict_types=1);

namespace StudentCorner\OfferCounter\Infrastructure\Persistence\Doctrine\Types;

use Shared\Infrastructure\Persistence\Doctrine\DBAL\IntegerValueObjectType;
use StudentCorner\OfferCounter\Domain\OfferCounterTotal;

final class OfferCounterTotalType extends IntegerValueObjectType
{
    public static function customTypeName(): string
    {
        return 'OfferCounterTotal';
    }

    protected function typeClassName(): string
    {
        return OfferCounterTotal::class;
    }
}

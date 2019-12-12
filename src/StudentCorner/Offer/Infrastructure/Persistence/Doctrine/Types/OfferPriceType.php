<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Infrastructure\Persistence\Doctrine\Types;

use Shared\Infrastructure\Persistence\Doctrine\DBAL\IntegerValueObjectType;
use StudentCorner\Offer\Domain\OfferPrice;

final class OfferPriceType extends IntegerValueObjectType
{
    public static function customTypeName(): string
    {
        return 'OfferPrice';
    }

    protected function typeClassName(): string
    {
        return OfferPrice::class;
    }
}

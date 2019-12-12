<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Infrastructure\Persistence\Doctrine\Types;

use Shared\Infrastructure\Persistence\Doctrine\DBAL\StringValueObjectType;
use StudentCorner\Offer\Domain\OfferName;

final class OfferNameType extends StringValueObjectType
{
    public static function customTypeName(): string
    {
        return 'OfferName';
    }

    protected function typeClassName(): string
    {
        return OfferName::class;
    }
}

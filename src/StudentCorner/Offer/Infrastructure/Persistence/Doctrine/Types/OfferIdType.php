<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Infrastructure\Persistence\Doctrine\Types;

use Shared\Infrastructure\Persistence\Doctrine\DBAL\UuidType;
use StudentCorner\Offer\Domain\OfferId;

final class OfferIdType extends UuidType
{
    public static function customTypeName(): string
    {
        return 'OfferId';
    }

    protected function typeClassName(): string
    {
        return OfferId::class;
    }
}

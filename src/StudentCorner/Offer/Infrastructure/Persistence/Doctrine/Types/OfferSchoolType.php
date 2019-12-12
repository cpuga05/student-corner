<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Infrastructure\Persistence\Doctrine\Types;

use Shared\Infrastructure\Persistence\Doctrine\DBAL\StringValueObjectType;
use StudentCorner\Offer\Domain\OfferSchool;

final class OfferSchoolType extends StringValueObjectType
{
    public static function customTypeName(): string
    {
        return 'OfferSchool';
    }

    protected function typeClassName(): string
    {
        return OfferSchool::class;
    }
}

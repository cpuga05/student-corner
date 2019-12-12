<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Infrastructure\Persistence\Doctrine\Types;

use Shared\Infrastructure\Persistence\Doctrine\DBAL\StringValueObjectType;
use StudentCorner\Offer\Domain\OfferTeacher;

final class OfferTeacherType extends StringValueObjectType
{
    public static function customTypeName(): string
    {
        return 'OfferTeacher';
    }

    protected function typeClassName(): string
    {
        return OfferTeacher::class;
    }
}

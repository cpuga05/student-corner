<?php

declare(strict_types=1);

namespace StudentCorner\Offer\Infrastructure\Persistence\Doctrine\Types;

use Shared\Infrastructure\Persistence\Doctrine\DBAL\StringValueObjectType;
use StudentCorner\Offer\Domain\OfferCourse;

final class OfferCourseType extends StringValueObjectType
{
    public static function customTypeName(): string
    {
        return 'OfferCourse';
    }

    protected function typeClassName(): string
    {
        return OfferCourse::class;
    }
}

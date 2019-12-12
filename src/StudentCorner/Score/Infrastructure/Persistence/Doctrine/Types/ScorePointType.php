<?php

declare(strict_types=1);

namespace StudentCorner\Score\Infrastructure\Persistence\Doctrine\Types;

use Shared\Infrastructure\Persistence\Doctrine\DBAL\IntegerValueObjectType;
use StudentCorner\Score\Domain\ScorePoint;

final class ScorePointType extends IntegerValueObjectType
{
    public static function customTypeName(): string
    {
        return 'ScorePoint';
    }

    protected function typeClassName(): string
    {
        return ScorePoint::class;
    }
}

<?php

declare(strict_types=1);

namespace StudentCorner\OfferCounter\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use Shared\Infrastructure\Persistence\Doctrine\DBAL\DoctrineCustomType;
use StudentCorner\Offer\Domain\OfferId;

use function Lambdish\Phunctional\map;

final class OfferIdsType extends JsonType implements DoctrineCustomType
{
    public static function customTypeName(): string
    {
        return 'OfferIds';
    }

    public function getName(): string
    {
        return self::customTypeName();
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValue(map(fn(OfferId $id) => $id->value(), $value), $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $scalars = parent::convertToPHPValue($value, $platform);

        return map(fn(string $value) => new OfferId($value), $scalars);
    }
}

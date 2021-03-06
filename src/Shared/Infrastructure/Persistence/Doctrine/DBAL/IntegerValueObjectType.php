<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\Doctrine\DBAL;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

abstract class IntegerValueObjectType extends IntegerType implements DoctrineCustomType
{
    public function getName(): string
    {
        return static::customTypeName();
    }

    public function convertToPHPValue(
        $value,
        AbstractPlatform $platform
    ) {
        $className = $this->typeClassName();

        return new $className((int)$value);
    }

    public function convertToDatabaseValue(
        $value,
        AbstractPlatform $platform
    ) {
        return $value->value();
    }

    abstract protected function typeClassName(): string;
}

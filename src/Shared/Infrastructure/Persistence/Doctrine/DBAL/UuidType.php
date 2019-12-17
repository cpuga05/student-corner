<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\Doctrine\DBAL;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Shared\Domain\ValueObject\Uuid;

abstract class UuidType extends StringType implements DoctrineCustomType
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

        return new $className($value);
    }

    public function convertToDatabaseValue(
        $value,
        AbstractPlatform $platform
    ) {
        if ($value instanceof Uuid) {
            return $value->value();
        }

        return $value;
    }

    abstract protected function typeClassName(): string;
}

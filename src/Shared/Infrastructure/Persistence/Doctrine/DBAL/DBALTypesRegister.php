<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\Doctrine\DBAL;

use Doctrine\DBAL\Types\Type;
use function Lambdish\Phunctional\each;

final class DBALTypesRegister
{
    private static bool $initialized = false;

    public static function register(array $dbalCustomTypeClasses): void
    {
        if (!self::$initialized)
        {
            /** @var DoctrineCustomType $dbalCustomTypeClass */
            foreach ($dbalCustomTypeClasses as $dbalCustomTypeClass) {
                Type::addType($dbalCustomTypeClass::customTypeName(), $dbalCustomTypeClass);
            }

            self::$initialized = true;
        }
    }
}

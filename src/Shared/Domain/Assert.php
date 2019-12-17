<?php

declare(strict_types=1);

namespace Shared\Domain;

use InvalidArgumentException;

use function get_class;
use function sprintf;

final class Assert
{
    public static function arrayOf(string $class, array $items): void
    {
        foreach ($items as $item) {
            static::instanceOf($class, $item);
        }
    }

    public static function instanceOf(string $class, $item): void
    {
        if (!$item instanceof $class) {
            throw new InvalidArgumentException(
                sprintf('The object <%s> is not an instance of <%s>', get_class($item), $class)
            );
        }
    }
}

<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

use ReflectionClass;
use Shared\Domain\Utils;

use function array_rand;
use function in_array;

abstract class Enum
{
    protected static array $cache = [];
    private $value;

    public function __construct($value)
    {
        $this->ensureIsBetweenAcceptedValues($value);

        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        return new static($value);
    }

    public static function random(): self
    {
        return new static(self::randomValue());
    }

    public static function randomValue()
    {
        return self::values()[array_rand(self::values())];
    }

    public static function values(): array
    {
        $class = static::class;

        if (!isset(self::$cache[$class])) {
            $reflected = new ReflectionClass($class);
            $constants = $reflected->getConstants();

            foreach ($constants as $key => $constant) {
                self::$cache[$class][Utils::toCameCase($key)] = $constant;
            }
        }

        return self::$cache[$class];
    }

    public function equals(self $enum): bool
    {
        return $enum->value() == $this->value();
    }

    public function value()
    {
        return $this->value;
    }

    private function ensureIsBetweenAcceptedValues($value): void
    {
        if (!in_array($value, static::values(), true)) {
            $this->throwExceptionForInvalidValue($value);
        }
    }

    abstract protected function throwExceptionForInvalidValue($value): void;

    public function __toString(): string
    {
        return (string)$this->value;
    }
}

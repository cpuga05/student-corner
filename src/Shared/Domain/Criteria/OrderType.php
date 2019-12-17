<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;

use InvalidArgumentException;
use Shared\Domain\ValueObject\Enum;

final class OrderType extends Enum
{
    public const ASC = 'asc';
    public const DESC = 'desc';
    public const NONE = 'none';

    public function isNone(): bool
    {
        return $this->equals(new self(self::NONE));
    }

    protected function throwExceptionForInvalidValue($value): void
    {
        throw new InvalidArgumentException($value);
    }
}

<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;

use Shared\Domain\Collection;
use function array_merge;
use function array_reduce;
use function sprintf;

final class Filters extends Collection
{
    protected function type(): string
    {
        return Filter::class;
    }

    public static function fromValues(array $values): self
    {
        $items = [];

        foreach ($values as $value) {
            $items[] = Filter::fromValues($value);
        }

        return new self($items);
    }

    public function add(Filter $filter): self
    {
        return new self(array_merge($this->items(), $filter));
    }

    public function filters(): array
    {
        return $this->items();
    }

    public function serialize(): string
    {
        return array_reduce(
            $this->items(),
            fn(string $accumulate, Filter $filter) => sprintf('%s^%s', $accumulate, $filter->serialize()),
            ''
        );
    }
}

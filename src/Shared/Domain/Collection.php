<?php

declare(strict_types=1);

namespace Shared\Domain;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use function count;

abstract class Collection implements Countable, IteratorAggregate
{
    private array $items;

    public function __construct(array $items)
    {
        Assert::arrayOf($this->type(), $items);

        $this->items = $items;
    }

    abstract protected function type(): string;

    protected function each(callable $fn)
    {
        foreach ($this->items() as $key => $value) {
            $fn($value, $key);
        }
    }

    protected function items(): array
    {
        return $this->items;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }
}

<?php

namespace App\Struct;

use Iterator;

abstract class Collection implements Iterator
{
    protected int $position;

    /** @var array<Struct> $items */
    protected array $items;

    public function __construct()
    {
        $this->rewind();
        $this->items = [];
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current(): Struct
    {
        return $this->items[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        return isset($this->items[$this->position]);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function shuffle(): void
    {
        shuffle($this->items);
    }

    public function getAt(int $key): ?Struct
    {
        return $this->items[$key] ?? null;
    }

}
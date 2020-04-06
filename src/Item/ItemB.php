<?php

declare(strict_types=1);

namespace VendingMachine\Item;

class ItemB implements Item
{
    private const SELECTOR = 'B';

    private int $value = 100;

    public function getValue(): int
    {
        return $this->value;
    }

    public function selector(): string
    {
        return self::SELECTOR;
    }
}

<?php

declare(strict_types=1);

namespace VendingMachine\Item;

class ItemA implements Item
{
    private const SELECTOR = 'B';

    private int $value = 65;

    public function value(): int
    {
        return $this->value;
    }

    public function selector(): string
    {
        return self::SELECTOR;
    }
}

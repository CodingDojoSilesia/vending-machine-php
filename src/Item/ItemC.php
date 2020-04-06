<?php


namespace VendingMachine\Item;


class ItemC implements Item
{
    private const SELECTOR = 'C';

    private int $value = 150;

    public function getValue(): int
    {
        return $this->value;
    }

    public function selector(): string
    {
        return self::SELECTOR;
    }
}

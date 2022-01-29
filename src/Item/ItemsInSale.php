<?php

declare(strict_types=1);

namespace VendingMachine\Item;

class ItemsInSale
{
    public static function getItems(): array
    {
        return [
            new ItemA(),
            new ItemB(),
            new ItemC()
        ];
    }

    public static function itemShortCodes(): array
    {
        return array_map(static fn(Item $money) => $money->selector(), self::getItems());
    }
}

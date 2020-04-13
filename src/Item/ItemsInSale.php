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
}

<?php

declare(strict_types=1);

namespace VendingMachine\Item;

class ItemA extends Item
{
    protected string $selector = 'A';

    protected int $value = 65;
}

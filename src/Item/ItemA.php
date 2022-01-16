<?php

declare(strict_types=1);

namespace VendingMachine\Item;

final class ItemA extends Item
{
    protected string $selector = 'A';

    protected int $value = 65;
}

<?php

declare(strict_types=1);

namespace VendingMachine\Item;

final class ItemB extends Item
{
    protected string $selector = 'B';

    protected int $value = 100;
}

<?php

declare(strict_types=1);

namespace VendingMachine\Item;

final class ItemC extends Item
{
    protected string $selector = 'C';

    protected int $value = 150;
}

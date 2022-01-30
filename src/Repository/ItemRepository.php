<?php

declare(strict_types=1);

namespace VendingMachine\Repository;

use VendingMachine\Item\Item;

interface ItemRepository
{
    public function add(Item $item): void;

    public function getItemBySelector(string $selector): ?Item;

    /** @return array|Item[] */
    public function getAll(): array;
}

<?php

declare(strict_types=1);

namespace VendingMachine\Repository;

use VendingMachine\Item\Item;

class InMemoryItemRepository implements ItemRepository
{
    /** @var array|Item[] */
    protected array $items = [];

    public function add(Item $item): void
    {
        $this->items[] = $item;
    }

    public function getItemBySelector($selector): ?Item
    {
        $filtered = array_filter($this->items, static function(Item $item) use ($selector) {
            return $item->equalsBySelector($selector);
        });

        return count($filtered) ? reset($filtered) : null;
    }

    public function getAll(): array
    {
        return $this->items;
    }
}

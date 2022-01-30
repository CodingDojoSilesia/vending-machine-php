<?php

declare(strict_types=1);

namespace VendingMachine\Item;

abstract class Item
{
    protected const SELECTOR = '';

    protected const VALUE = 0;

    public function value(): int
    {
        return static::VALUE;
    }

    public function selector(): string
    {
        return static::SELECTOR;
    }

    public function equalsBySelector(string $selector): bool
    {
        return static::SELECTOR === $selector;
    }

    public function enoughToBuy(int $count): bool
    {
        return $count >= static::VALUE;
    }
}

<?php

declare(strict_types=1);

namespace VendingMachine\Item;

class ItemA
{
    private int $value = 65;

    public function value(): int
    {
        return $this->value;
    }
}

<?php

declare(strict_types=1);

namespace VendingMachine\Item;

class ItemB
{
    private int $value = 100;

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}

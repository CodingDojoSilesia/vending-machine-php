<?php


namespace VendingMachine\Item;


class ItemC
{
    private int $value = 150;

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}

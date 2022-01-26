<?php

declare(strict_types=1);

namespace VendingMachine\Response;

use VendingMachine\Item\Item;
use VendingMachine\Model\MoneyCollection;

class ConsoleResponse
{
    private Item $product;

    private MoneyCollection $rest;

    public function setRest(MoneyCollection $rest): ConsoleResponse
    {
        $this->rest = $rest;
        return $this;
    }

    public function rest(): MoneyCollection
    {
        return $this->rest;
    }

    public function setProduct(Item $product): void
    {
        $this->product = $product;
    }

    public function getOutput(): string
    {
        return $this->product->selector();
    }
}

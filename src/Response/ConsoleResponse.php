<?php

declare(strict_types=1);

namespace VendingMachine\Response;

use VendingMachine\Item\Item;
use VendingMachine\Model\MoneyCollection;

class ConsoleResponse extends Response
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

    public function result(): array
    {
        return [
            "product" => $this->product,
            "rest"    => $this->rest
        ];
    }

    public function __toString(): string
    {
        return implode(', ', array: [$this->product->selector(), ...$this->rest->toArray()]);
    }
}

<?php

declare(strict_types=1);

namespace VendingMachine\Request;

use VendingMachine\Item\Item;
use VendingMachine\Model\MoneyCollection;

class BuyItemRequest
{
    /**
     * @var Item
     */
    private Item $item;

    /**
     * @var MoneyCollection
     */
    private MoneyCollection $moneyCollection;

    public function __construct(Item $item, MoneyCollection $moneyCollection)
    {
        $this->item = $item;
        $this->moneyCollection = $moneyCollection;
    }

    /**
     * @return MoneyCollection
     */
    public function moneyCollection(): MoneyCollection
    {
        return $this->moneyCollection;
    }

    /**
     * @return Item
     */
    public function item(): Item
    {
        return $this->item;
    }
}

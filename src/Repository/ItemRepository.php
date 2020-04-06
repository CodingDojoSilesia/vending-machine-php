<?php

namespace VendingMachine\Repository;

use VendingMachine\Item\Item;

interface ItemRepository
{
    public function getItemBySelector($selector): Item;
}

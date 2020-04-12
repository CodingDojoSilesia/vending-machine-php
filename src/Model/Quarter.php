<?php

declare(strict_types=1);

namespace VendingMachine\Model;

class Quarter extends Money implements Coin
{
    protected string $shortCode = 'Q';

    protected int $value = 25;
}

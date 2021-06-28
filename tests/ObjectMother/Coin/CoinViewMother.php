<?php

declare(strict_types=1);

namespace VendingMachine\ObjectMother\Coin;

use VendingMachine\Domain\Coin\View\Coin;

class CoinViewMother
{
    public static function quarter(int $quantity): Coin
    {
        return new Coin('Q', 'USD', 25, $quantity);
    }

    public static function dime(int $quantity): Coin
    {
        return new Coin('D', 'USD', 10, $quantity);
    }

    public static function nickel(int $quantity): Coin
    {
        return new Coin('N', 'USD', 5, $quantity);
    }
}

<?php
declare(strict_types=1);

namespace VendingMachine\ObjectMother\Machine;

use VendingMachine\Domain\Machine\View\Machine;
use VendingMachine\ObjectMother\Coin\CoinViewMother;

class MachineViewMother
{
    public static function filled(): Machine
    {
        return new Machine(1000, 100, [
            CoinViewMother::quarter(20),
            CoinViewMother::dime(25),
            CoinViewMother::nickel(50),
        ]);
    }
}

<?php

declare(strict_types=1);

namespace VendingMachine\ObjectMother\Machine;

use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;
use VendingMachine\Domain\Machine\Machine;

class MachineMother
{
    public static function filled(): Machine
    {
        $machine = new Machine();

        foreach (ShortCode::VALID_SHORTCODES as $shortCode => $amount) {
            $machine->createCoin(ShortCode::fromString($shortCode), Quantity::fromInteger(10));
            $machine->insertCoin(ShortCode::fromString($shortCode), Quantity::fromInteger(1));
        }

        return $machine;
    }
}

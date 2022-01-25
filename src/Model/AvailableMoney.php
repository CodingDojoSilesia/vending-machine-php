<?php

declare(strict_types=1);

namespace VendingMachine\Model;

final class AvailableMoney
{
    public static function getMoney(): array
    {
        return [
            new Nickel(),
            new Dime(),
            new Quarter(),
            new Dollar()
        ];
    }

    public static function coins()
    {
        return [
            new Nickel(),
            new Dime(),
            new Quarter(),
        ];
    }
}

<?php

declare(strict_types=1);

namespace VendingMachine\Model;

final class AvailableMoney
{
    public static function getMoney(): array
    {
        // @TODO load class from specific dir/namespace
        return [
            new Nickel(),
            new Dime(),
            new Quarter(),
            new Dollar()
        ];
    }
}

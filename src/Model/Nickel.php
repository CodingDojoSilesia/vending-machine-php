<?php

declare(strict_types=1);

namespace VendingMachine\Model;

final class Nickel extends Money implements Coin, MoneyCreationInterface
{
    protected const SHORT_CODE  = 'N';

    protected const VALUE = 5;

    public static function create(): Nickel
    {
        return new Nickel(self::SHORT_CODE, self::VALUE);
    }
}

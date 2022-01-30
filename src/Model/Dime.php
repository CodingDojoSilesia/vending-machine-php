<?php

declare(strict_types=1);

namespace VendingMachine\Model;

final class Dime extends Money implements Coin, MoneyCreationInterface
{
    protected const SHORT_CODE  = 'D';

    protected const VALUE = 10;

    public static function create(): Dime
    {
        return new Dime(self::SHORT_CODE, self::VALUE);
    }
}

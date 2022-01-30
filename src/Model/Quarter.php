<?php

declare(strict_types=1);

namespace VendingMachine\Model;

class Quarter extends Money implements Coin
{
    protected const SHORT_CODE  = 'Q';

    protected const VALUE = 25;

    public static function create(): Quarter
    {
        return new Quarter(self::SHORT_CODE, self::VALUE);
    }
}

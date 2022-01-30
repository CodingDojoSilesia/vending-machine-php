<?php

declare(strict_types=1);

namespace VendingMachine\Model;

final class Dollar extends Money implements PaperMoney, MoneyCreationInterface
{
    protected const SHORT_CODE  = 'DOLLAR';

    protected const VALUE = 100;

    public static function create(): Dollar
    {
        return new Dollar(self::SHORT_CODE, self::VALUE);
    }
}

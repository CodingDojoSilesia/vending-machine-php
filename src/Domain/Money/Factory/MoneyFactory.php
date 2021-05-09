<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Money\Factory;

use VendingMachine\Domain\Money\Money;
use VendingMachine\Domain\Money\ShortCode;

abstract class MoneyFactory
{
    public static function fromShortCode(ShortCode $code): Money
    {
        return Money::USD(ShortCode::VALID_SHORTCODES[$code->getCode()]);
    }
}

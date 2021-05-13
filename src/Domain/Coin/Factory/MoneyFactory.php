<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin\Factory;

use VendingMachine\Domain\Coin\Money;
use VendingMachine\Domain\Coin\ShortCode;

abstract class MoneyFactory
{
    public static function fromShortCode(ShortCode $code): Money
    {
        return Money::USD(ShortCode::VALID_SHORTCODES[$code->getCode()]);
    }
}

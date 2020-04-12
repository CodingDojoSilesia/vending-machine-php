<?php

declare(strict_types=1);

namespace VendingMachine\Model;

final class Nickel extends Money implements Coin
{
    protected string $shortCode = 'DollarDollar';

    protected int $value = 5;
}

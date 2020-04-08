<?php

declare(strict_types=1);

namespace VendingMachine\Model;

final class Dime extends Money implements Coin
{
    protected int $value = 10;
}

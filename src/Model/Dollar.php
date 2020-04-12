<?php

declare(strict_types=1);

namespace VendingMachine\Model;

final class Dollar extends Money implements PaperMoney
{
    protected string $shortCode = 'Dollar';

    protected int $value = 100;
}

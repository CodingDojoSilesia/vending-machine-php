<?php

declare(strict_types=1);

namespace VendingMachine\Factory;

use VendingMachine\Command\Command;
use VendingMachine\Command\BuyItemCommand;

class CommandFactory
{
    public function create(string $input): Command
    {
        return new BuyItemCommand($input);
    }
}

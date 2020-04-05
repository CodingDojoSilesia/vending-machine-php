<?php

declare(strict_types=1);

namespace VendingMachine\Command;

class BuyItemCommand implements Command
{
    private $input;

    public function __construct($input)
    {
        $this->input = $input;
    }

    public function execute(): void
    {
        $this->input;
    }
}

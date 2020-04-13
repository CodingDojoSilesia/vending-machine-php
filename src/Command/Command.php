<?php

declare(strict_types=1);

namespace VendingMachine\Command;

use VendingMachine\Request\Request;

interface Command
{
    public function execute(Request $request);
}

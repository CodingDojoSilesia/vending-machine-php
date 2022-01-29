<?php

declare(strict_types=1);

namespace VendingMachine\Command;

use VendingMachine\Request\CommandRequest;
use VendingMachine\Response\Response;

interface Command
{
    public function execute(CommandRequest $request): Response;
}

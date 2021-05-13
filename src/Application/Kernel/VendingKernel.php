<?php
declare(strict_types=1);

namespace VendingMachine\Application\Kernel;

use VendingMachine\Application\Bus\MessageBus;

class VendingKernel implements Kernel
{
    private MessageBus $commandBus;

    public function __construct(MessageBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(object $command): void
    {
        $this->commandBus->dispatch($command);
    }
}

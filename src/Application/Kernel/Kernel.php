<?php
declare(strict_types=1);

namespace VendingMachine\Application\Kernel;

interface Kernel
{
    public function handle(object $command): void;
}

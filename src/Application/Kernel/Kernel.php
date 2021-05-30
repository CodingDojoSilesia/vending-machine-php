<?php
declare(strict_types=1);

namespace VendingMachine\Application\Kernel;

use VendingMachine\Domain\Shared\Command\CommandInterface;
use VendingMachine\Domain\Shared\Query\QueryInterface;

interface Kernel
{
    public function handle(CommandInterface $command): void;
    public function query(QueryInterface $query): object;
}

<?php
declare(strict_types=1);

namespace VendingMachine\Application\Kernel;

use VendingMachine\Application\Bus\CommandBus;
use VendingMachine\Application\Bus\QueryBus;
use VendingMachine\Domain\Shared\Command\CommandInterface;
use VendingMachine\Domain\Shared\Query\QueryInterface;

final class VendingKernel implements Kernel
{
    public function __construct(private CommandBus $commandBus, private QueryBus $queryBus){}

    public function handle(CommandInterface $command): void
    {
        $this->commandBus->dispatch($command);
    }

    public function query(QueryInterface $query): object
    {
        return $this->queryBus->dispatch($query);
    }
}

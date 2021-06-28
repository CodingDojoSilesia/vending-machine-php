<?php

declare(strict_types=1);

namespace VendingMachine\Application\Handler;

use VendingMachine\Domain\Coin\Command\InsertCoin;
use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;
use VendingMachine\Domain\Machine\Exception\MachineNotFoundException;
use VendingMachine\Domain\Machine\MachineRepository;

final class InsertCoinHandler
{
    private MachineRepository $repository;

    public function __construct(MachineRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(InsertCoin $command): void
    {
        $machine = $this->repository->findOne();

        if (!$machine) {
            throw new MachineNotFoundException();
        }

        $machine->insertCoin(ShortCode::fromString($command->getShortCode()), Quantity::fromInteger($command->getQuantity()));

        $this->repository->save($machine);
    }
}

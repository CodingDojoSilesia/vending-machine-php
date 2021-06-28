<?php

declare(strict_types=1);

namespace VendingMachine\Application\Handler;

use VendingMachine\Domain\Machine\Command\CreateMachine;
use VendingMachine\Domain\Machine\Exception\MachineAlreadyExists;
use VendingMachine\Domain\Machine\Machine;
use VendingMachine\Domain\Machine\MachineRepository;

final class CreateMachineHandler
{
    public function __construct(private MachineRepository $repository){}

    public function handle(CreateMachine $command): void
    {
        if ($this->repository->findOne() instanceof Machine) {
            throw new MachineAlreadyExists();
        }

        $this->repository->save(new Machine());
    }
}

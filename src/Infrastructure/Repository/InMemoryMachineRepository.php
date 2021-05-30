<?php
declare(strict_types=1);

namespace VendingMachine\Infrastructure\Repository;

use VendingMachine\Domain\Machine\Machine;
use VendingMachine\Domain\Machine\MachineRepository;

final class InMemoryMachineRepository implements MachineRepository
{
    private ?Machine $machine = null;

    public function findOne(): ?Machine
    {
        return $this->machine;
    }

    public function save(Machine $machine): void
    {
        $this->machine = $machine;
    }
}

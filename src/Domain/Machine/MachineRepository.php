<?php

declare(strict_types=1);

namespace VendingMachine\Domain\Machine;

interface MachineRepository
{
    public function findOne(): ?Machine;
    public function save(Machine $machine): void;
}

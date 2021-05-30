<?php

namespace VendingMachine\Application\Handler;

use VendingMachine\Domain\Machine\View\Machine;
use VendingMachine\Domain\Machine\Query\GetMachine;
use VendingMachine\Application\Projection\MachineFinder;

final class GetMachineHandler
{
    public function __construct(private MachineFinder $finder){}

    public function handle(GetMachine $query): Machine
    {
        return $this->finder->findOne();
    }
}

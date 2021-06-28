<?php

use VendingMachine\Application\Handler\{
    CreateCoinHandler,
    GetMachineHandler,
    InsertCoinHandler,
    ReturnCoinHandler,
    CreateMachineHandler,
};
use VendingMachine\Domain\Coin\Command\{
    CreateCoin,
    InsertCoin,
    ReturnCoin,
};
use VendingMachine\Domain\Machine\Command\CreateMachine;
use VendingMachine\Domain\Machine\Query\GetMachine;
use VendingMachine\Infrastructure\Projection\InMemoryMachineFinder;
use VendingMachine\Infrastructure\Repository\InMemoryMachineRepository;

/** @var InMemoryMachineRepository $machineRepository */
/** @var InMemoryMachineFinder $machineFinder */
return [
    'commands' => [
        CreateCoin::class    => new CreateCoinHandler($machineRepository),
        InsertCoin::class    => new InsertCoinHandler($machineRepository),
        ReturnCoin::class    => new ReturnCoinHandler($machineRepository),
        CreateMachine::class => new CreateMachineHandler($machineRepository),
    ],
    'queries'  => [
        GetMachine::class => new GetMachineHandler($machineFinder)
    ]
];

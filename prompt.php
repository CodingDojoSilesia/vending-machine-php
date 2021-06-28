<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

use VendingMachine\Application\Bus\{CommandBus, QueryBus};
use VendingMachine\Application\Kernel\VendingKernel;
use VendingMachine\Application\Service\VendingService;
use VendingMachine\Infrastructure\Projection\InMemoryMachineFinder;
use VendingMachine\Infrastructure\Repository\InMemoryMachineRepository;
use VendingMachine\UserInterface\VendingMachine;

$machineRepository = new InMemoryMachineRepository();
$machineFinder     = new InMemoryMachineFinder($machineRepository);
$commandBus        = new CommandBus();
$queryBus          = new QueryBus();
$kernel            = new VendingKernel($commandBus, $queryBus);
$vendingService    = new VendingService($kernel);
$vendingMachine    = new VendingMachine($vendingService);
$config            = require_once 'config.php';

foreach ($config['commands'] as $command => $handler) {
    $commandBus->attach($command, [$handler, 'handle']);
};

foreach ($config['queries'] as $query => $handler) {
    $queryBus->attach($query, [$handler, 'handle']);
};

$vendingService->init();
$input = '';

while ($input !== 'EXIT') {
    echo "\nInsert command: \n";
    $input = mb_strtoupper(rtrim(fgets(STDIN)));

    switch ($input) {
        case 'N':
        case 'D':
        case 'Q':
        case 'DOL':
            $vendingMachine->insertCoin($input);
            break;
        case 'COIN-RETURN':
            $vendingMachine->returnCoins();
            break;
        case 'service':
            echo $vendingMachine->service() . "\n";
            break;
    }
}

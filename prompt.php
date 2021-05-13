<?php
declare(strict_types=1);

require_once './vendor/autoload.php';

use VendingMachine\Application\Bus\CommandBus;
use VendingMachine\Application\Kernel\VendingKernel;
use VendingMachine\Infrastructure\Repository\InMemoryCoinRepository;
use VendingMachine\UserInterface\VendingMachine;
use VendingMachine\Application\Service\VendingService;

$coinRepository = new InMemoryCoinRepository();
$commandBus     = new CommandBus();
$kernel         = new VendingKernel($commandBus);
$vendingService = new VendingService($kernel);
$vendingMachine = new VendingMachine($vendingService);
$config         = require_once 'config.php';

foreach ($config as $command => $handler) {
    $commandBus->attach($command, [$handler, 'handle']);
};

$vendingService->init();
$input = '';

while ($input !== 'exit') {
    echo "\nInsert command: \n";
    $input = rtrim(fgets(STDIN));

    switch ($input) {
        case 'N':
        case 'D':
        case 'Q':
        case 'DOL':
            $vendingMachine->insertCoin($input);
            break;
        case 'service':
            echo $vendingMachine->service() . "\n";
            break;
    }
}

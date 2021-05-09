<?php
declare(strict_types=1);

require_once './vendor/autoload.php';

use VendingMachine\Application\ServiceBus\CommandBus;
use VendingMachine\Application\Kernel\VendingKernel;
use VendingMachine\Infrastructure\Repository\InMemoryCoinRepository;
use VendingMachine\UserInterface\VendingMachine;

$coinRepository = new InMemoryCoinRepository();
$commandBus     = new CommandBus();
$system         = new VendingKernel($commandBus);
$vendingMachine = new VendingMachine($system);
$config         = require_once 'config.php';

foreach ($config as $command => $handler) {
    $commandBus->attach($command, [$handler, 'handle']);
};

$vendingMachine->init();
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

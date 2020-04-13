<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use VendingMachine\Item\ItemB;
use VendingMachine\Repository\InMemoryItemRepository;
use VendingMachine\Util\ConsoleInputParser;
use VendingMachine\VendingMachine;


$itemRepository = new InMemoryItemRepository();
$itemRepository->add(new ItemB());


$vm = new VendingMachine($itemRepository, new ConsoleInputParser());
$input = '';

while ($input !== 'exit') {
    echo "Insert command: \n";
    $input = rtrim(fgets(STDIN));

    switch ($input) {
        case 'service':
            echo $vm->execute($input) . "\n";
            break;
        default:
            echo $vm->execute($input) . "\n";
    }
}

<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use VendingMachine\VendingMachine;

$vm = new VendingMachine();
$input = '';

while ($input !== 'exit') {
    echo "Insert command: \n";
    $input = rtrim(fgets(STDIN));

    switch ($input) {
        case 'service':
            echo $vm->execute() . "\n";
            break;
    }
}

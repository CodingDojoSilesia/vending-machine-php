<?php

use VendingMachine\Application\Coin\Command\{
    CreateCoin,
    InsertCoin,
    ReturnCoin,
};
use VendingMachine\Application\Coin\Handler\{
    CreateCoinHandler,
    InsertCoinHandler,
    ReturnCoinHandler,
};
use VendingMachine\Infrastructure\Repository\InMemoryCoinRepository;

/** @var InMemoryCoinRepository $coinRepository */
return [
    CreateCoin::class => new CreateCoinHandler($coinRepository),
    InsertCoin::class => new InsertCoinHandler($coinRepository),
    ReturnCoin::class => new ReturnCoinHandler($coinRepository),
];

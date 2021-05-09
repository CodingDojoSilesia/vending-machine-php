<?php

use VendingMachine\Domain\Money\Command\{
    CreateCoin,
    CreateCoinHandler,
    InsertCoin,
    InsertCoinHandler,
    ReturnCoin,
    ReturnCoinHandler
};
use VendingMachine\Infrastructure\Repository\InMemoryCoinRepository;

/** @var InMemoryCoinRepository $coinRepository */
return [
    CreateCoin::class => new CreateCoinHandler($coinRepository),
    InsertCoin::class => new InsertCoinHandler($coinRepository),
    ReturnCoin::class => new ReturnCoinHandler($coinRepository),
];

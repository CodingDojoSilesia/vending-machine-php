<?php
declare(strict_types=1);

namespace VendingMachine\Application\Handler;

use VendingMachine\Application\Command\InsertCoin;
use VendingMachine\Domain\Coin\CoinRepository;
use VendingMachine\Domain\Coin\Exception\CoinNotFoundException;

final class InsertCoinHandler
{
    private CoinRepository $repository;

    public function __construct(CoinRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(InsertCoin $command): void
    {
        $coin = $this->repository->findByShortCode($command->getShortCode());

        if (!$coin) {
            throw new CoinNotFoundException($command->getShortCode());
        }

        $coin->insertCoin($command->getQuantity());

        $this->repository->save($coin);
    }
}

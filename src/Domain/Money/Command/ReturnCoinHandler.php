<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Money\Command;

use VendingMachine\Domain\Money\CoinRepository;
use VendingMachine\Domain\Money\Exception\CoinNotFoundException;

final class ReturnCoinHandler
{
    private CoinRepository $repository;

    public function __construct(CoinRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ReturnCoin $command): void
    {
        $coin = $this->repository->findByShortCode($command->getShortCode());

        if (!$coin) {
            throw new CoinNotFoundException($command->getShortCode());
        }

        $coin->returnCoin($command->getQuantity());

        $this->repository->save($coin);
    }
}

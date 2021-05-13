<?php
declare(strict_types=1);

namespace VendingMachine\Application\Handler;

use VendingMachine\Application\Command\ReturnCoin;
use VendingMachine\Domain\Coin\CoinRepository;
use VendingMachine\Domain\Coin\Exception\CoinNotFoundException;

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

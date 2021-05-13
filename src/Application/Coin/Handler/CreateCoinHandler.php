<?php
declare(strict_types=1);

namespace VendingMachine\Application\Coin\Handler;

use VendingMachine\Application\Coin\Command\CreateCoin;
use VendingMachine\Domain\Coin\Coin;
use VendingMachine\Domain\Coin\CoinRepository;

use VendingMachine\Domain\Coin\Exception\CoinAlreadyExist;

final class CreateCoinHandler
{
    private CoinRepository $repository;

    public function __construct(CoinRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(CreateCoin $command): void
    {
        $coin = $this->repository->findByShortCode($command->getShortCode());

        if ($coin instanceof Coin) {
            throw new CoinAlreadyExist($command->getShortCode());
        }

        $coin = Coin::withData($command->getShortCode(), $command->getQuantity());

        $this->repository->save($coin);
    }
}

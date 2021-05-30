<?php
declare(strict_types=1);

namespace VendingMachine\Infrastructure\Projection;

use VendingMachine\Application\Projection\MachineFinder;
use VendingMachine\Domain\Coin\Coin;
use VendingMachine\Domain\Coin\View\Coin as CoinView;
use VendingMachine\Domain\Machine\Exception\MachineNotFoundException;
use VendingMachine\Domain\Machine\MachineRepository;
use VendingMachine\Domain\Machine\View\Machine;

final class InMemoryMachineFinder implements MachineFinder
{
    public function __construct(private MachineRepository $repository){}

    public function findOne(): Machine
    {
        $machine = $this->repository->findOne();

        if (is_null($machine)){
            throw new MachineNotFoundException();
        }

        $coins = array_map(fn(Coin $coin) =>
            new CoinView(
                (string)$coin->getShortCode(),
                $coin->getAmount()->getCurrency(),
                $coin->getAmount()->getAmount(),
                $coin->getQuantity()->count()
            ), $machine->getCoins()
        );

        return new Machine(
            $machine->getTotalBalance()->getAmount(),
            $machine->getClientBalance()->getAmount(),
            $coins
        );
    }
}

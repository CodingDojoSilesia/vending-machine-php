<?php

declare(strict_types=1);

namespace VendingMachine\Domain\Machine;

use ArrayObject;
use VendingMachine\Domain\Coin\Coin;
use VendingMachine\Domain\Coin\Event\{
    CoinWasCreated,
    CoinWasInserted,
    CoinWasReturned,
};
use VendingMachine\Domain\Coin\Exception\{
    CoinAlreadyExist,
    CoinNotFoundException,
};
use VendingMachine\Domain\Coin\Factory\MoneyFactory;
use VendingMachine\Domain\Coin\{
    Money,
    Quantity,
    ShortCode,
};
use VendingMachine\Domain\Machine\Event\MachineWasCreated;
use VendingMachine\Domain\Shared\Exception\BalanceException;
use VendingMachine\Domain\Shared\Aggregate\AggregateRoot;

final class Machine extends AggregateRoot
{
    private Money       $totalBalance;
    private Money       $clientBalance;
    private ArrayObject $coins;

    public function __construct()
    {
        $this->record(new MachineWasCreated());
    }

    public function getTotalBalance(): Money
    {
        return $this->totalBalance;
    }

    public function getClientBalance(): Money
    {
        return $this->clientBalance;
    }

    public function getCoins(): array
    {
        return $this->coins->getArrayCopy();
    }

    public function createCoin(ShortCode $shortCode, Quantity $quantity): void
    {
        if ($this->coins->offsetExists((string)$shortCode)) {
            throw new CoinAlreadyExist($shortCode);
        }

        $this->record(CoinWasCreated::withData($shortCode, MoneyFactory::fromShortCode($shortCode), $quantity));
    }

    public function insertCoin(ShortCode $shortCode, Quantity $quantity): void
    {
        $coin = $this->coins->offsetExists((string)$shortCode);

        if (!$coin) {
            throw new CoinNotFoundException($shortCode);
        }

        $this->record(CoinWasInserted::withData($shortCode, $quantity));
    }

    public function returnCoin(ShortCode $shortCode, Quantity $quantity): void
    {
        if (!$this->coins->offsetExists((string)$shortCode)) {
            throw new CoinNotFoundException($shortCode);
        }

        $coin = $this->coins->offsetGet((string)$shortCode);

        if ($this->totalBalance->lessThan($coin->getAmount()->multiply($quantity))) {
            throw new BalanceException('Machine balance is less than expected.');
        }

        if ($this->clientBalance->lessThan($coin->getAmount()->multiply($quantity))) {
            throw new BalanceException('Client balance is less than expected.');
        }

        $this->record(CoinWasReturned::withData($shortCode, $coin->getAmount(), $quantity));
    }

    protected function whenMachineWasCreated(MachineWasCreated $event): void
    {
        $this->coins         = new ArrayObject();
        $this->totalBalance  = Money::USD(0);
        $this->clientBalance = Money::USD(0);
    }

    protected function whenCoinWasCreated(CoinWasCreated $event): void
    {
        $coin = Coin::withData($event->getShortCode(), $event->getAmount(), $event->getQuantity());
        $this->coins->offsetSet((string)$coin->getShortCode(), $coin);

        for ($i = 0; $i < $event->getQuantity()->count(); $i++) {
            $this->totalBalance = $this->totalBalance->add($coin->getAmount());
        }
    }

    protected function whenCoinWasInserted(CoinWasInserted $event): void
    {
        $coin = $this->coins->offsetGet((string)$event->getShortCode());

        $coin->increase($event->getQuantity());
        $this->coins->offsetSet((string)$coin->getShortCode(), $coin);

        for ($i = 0; $i < $event->getQuantity()->count(); $i++) {
            $this->totalBalance  = $this->totalBalance->add($coin->getAmount());
            $this->clientBalance = $this->clientBalance->add($coin->getAmount());
        }
    }

    protected function whenCoinWasReturned(CoinWasReturned $event): void
    {
        $coin = $this->coins->offsetGet((string)$event->getShortCode());

        $coin->decrease($event->getQuantity());
        $this->coins->offsetSet((string)$coin->getShortCode(), $coin);

        for ($i = 0; $i < $event->getQuantity()->count(); $i++) {
            $this->totalBalance  = $this->totalBalance->sub($coin->getAmount());
            $this->clientBalance = $this->clientBalance->sub($coin->getAmount());
        }
    }
}

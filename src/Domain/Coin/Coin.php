<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin;

use VendingMachine\Domain\AggregateRoot;
use VendingMachine\Domain\Coin\Event\CoinWasCreated;
use VendingMachine\Domain\Coin\Event\CoinWasInserted;
use VendingMachine\Domain\Coin\Event\CoinWasReturned;
use VendingMachine\Domain\Coin\Factory\MoneyFactory;

final class Coin extends AggregateRoot
{
    private ShortCode $code;
    private Money     $amount;
    private Quantity  $quantity;

    private function __construct(ShortCode $code, Money $amount, Quantity $quantity)
    {
        $this->record(CoinWasCreated::withData($code, $amount, $quantity ));
    }

    public static function withData(ShortCode $code, Quantity $quantity): self
    {
        return new self($code, MoneyFactory::fromShortCode($code), $quantity);
    }

    public function getShortCode(): ShortCode
    {
        return $this->code;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getQuantity(): Quantity
    {
        return $this->quantity;
    }

    public function insertCoin(Quantity $quantity): void
    {
        $this->record(CoinWasInserted::withData($this->code, $this->amount, $quantity));
    }

    public function returnCoin(Quantity $quantity): void
    {
        $this->record(CoinWasReturned::withData($this->code, $this->amount, $quantity));
    }

    protected function apply(object $event): void
    {
        switch (get_class($event)) {
            case CoinWasCreated::class:
                /** @var CoinWasCreated $event */
                $this->code     = $event->getCode();
                $this->amount   = $event->getAmount();
                $this->quantity = $event->getQuantity();
                break;
            case CoinWasInserted::class:
                /** @var CoinWasInserted $event */
                $this->quantity = $this->quantity->add($event->getQuantity());
                break;
            case CoinWasReturned::class:
                /** @var CoinWasReturned $event */
                $this->quantity = $this->quantity->sub($event->getQuantity());
                break;
        }
    }
}

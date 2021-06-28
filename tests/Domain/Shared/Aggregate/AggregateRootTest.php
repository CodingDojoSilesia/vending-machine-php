<?php

declare(strict_types=1);

namespace VendingMachine\Domain\Shared\Aggregate;

use LogicException;
use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Coin\Event\CoinWasCreated;
use VendingMachine\Domain\Coin\Event\CoinWasInserted;
use VendingMachine\Domain\Coin\Money;
use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;

class AggregateRootTest extends TestCase
{
    private AggregateRoot $aggregate;

    protected function setUp(): void
    {
        parent::setUp();

        $this->aggregate = new class extends AggregateRoot {

            public function testRecord(object $event): void
            {
                $this->record($event);
            }

            protected function whenCoinWasInserted(CoinWasInserted $event)
            {
                echo $event->getShortCode();
                echo $event->getQuantity()->count();
            }
        };
    }

    public function testCallExistingHandlerMethod()
    {
        $event = CoinWasInserted::withData(ShortCode::fromString('D'), Quantity::fromInteger(1));
        $this->expectOutputString('D1');
        $this->aggregate->testRecord($event);
    }

    public function testCallNotExistingHandlerMethod()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Missing event handler method whenCoinWasCreated for aggregate root');
        $event = CoinWasCreated::withData(ShortCode::fromString('D'), Money::USD(0), Quantity::fromInteger(1));
        $this->aggregate->testRecord($event);
    }
}

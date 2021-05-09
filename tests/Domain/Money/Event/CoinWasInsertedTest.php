<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Money\Event;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Money\Money;
use VendingMachine\Domain\Money\Quantity;
use VendingMachine\Domain\Money\ShortCode;

class CoinWasInsertedTest extends TestCase
{
    private ShortCode $code;
    private Money     $amount;
    private Quantity  $quantity;

    protected function setUp(): void
    {
        parent::setUp();

        $this->code     = ShortCode::fromString('DOL');
        $this->amount   = Money::USD(100);
        $this->quantity = Quantity::fromInteger(1);
    }


    public function testInstance(): CoinWasInserted
    {
        $event = CoinWasInserted::withData($this->code, $this->amount, $this->quantity);
        $this->assertInstanceOf(CoinWasInserted::class, $event);

        return $event;
    }

    /**
     * @param CoinWasInserted $event
     *
     * @depends testInstance
     */
    public function testGetters(CoinWasInserted $event): void
    {
        $this->assertInstanceOf(Money::class, $event->getAmount());
        $this->assertInstanceOf(Quantity::class, $event->getQuantity());
        $this->assertInstanceOf(ShortCode::class, $event->getCode());
    }
}

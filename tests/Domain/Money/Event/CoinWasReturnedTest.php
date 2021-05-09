<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Money\Event;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Money\Money;
use VendingMachine\Domain\Money\Quantity;
use VendingMachine\Domain\Money\ShortCode;

class CoinWasReturnedTest extends TestCase
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


    public function testInstance(): CoinWasReturned
    {
        $event = CoinWasReturned::withData($this->code, $this->amount, $this->quantity);
        $this->assertInstanceOf(CoinWasReturned::class, $event);

        return $event;
    }

    /**
     * @param CoinWasReturned $event
     *
     * @depends testInstance
     */
    public function testGetters(CoinWasReturned $event): void
    {
        $this->assertInstanceOf(Money::class, $event->getAmount());
        $this->assertInstanceOf(Quantity::class, $event->getQuantity());
        $this->assertInstanceOf(ShortCode::class, $event->getCode());
    }
}

<?php

declare(strict_types=1);

namespace VendingMachine\Domain\Coin\Event;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;

class CoinWasInsertedTest extends TestCase
{
    private ShortCode $code;
    private Quantity  $quantity;

    protected function setUp(): void
    {
        parent::setUp();

        $this->code     = ShortCode::fromString('DOL');
        $this->quantity = Quantity::fromInteger(1);
    }


    public function testInstance(): CoinWasInserted
    {
        $event = CoinWasInserted::withData($this->code, $this->quantity);
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
        $this->assertInstanceOf(Quantity::class, $event->getQuantity());
        $this->assertInstanceOf(ShortCode::class, $event->getShortCode());
    }
}

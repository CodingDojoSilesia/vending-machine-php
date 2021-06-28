<?php

declare(strict_types=1);

namespace VendingMachine\Domain\Coin;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Coin\Factory\MoneyFactory;

class CoinTest extends TestCase
{
    public function testCreate(): Coin
    {
        $shortCode = ShortCode::fromString('Q');
        $amount    = MoneyFactory::fromShortCode($shortCode);
        $quantity  = Quantity::fromInteger(10);
        $coin      = Coin::withData($shortCode, $amount, $quantity);

        $this->assertInstanceOf(Coin::class, $coin);

        return $coin;
    }

    /**
     * @param Coin $coin
     *
     * @depends testCreate
     */
    public function testGetters(Coin $coin)
    {
        $shortCode = $coin->getShortCode();
        $amount    = $coin->getAmount();
        $quantity  = $coin->getQuantity();
        $this->assertInstanceOf(ShortCode::class, $shortCode);
        $this->assertInstanceOf(Money::class, $amount);
        $this->assertInstanceOf(Quantity::class, $quantity);
        $this->assertEquals('Q', $shortCode->getCode());
        $this->assertEquals(25, $amount->getAmount());
        $this->assertEquals(10, $quantity->count());
    }

    /**
     * @param Coin $coin
     *
     * @depends clone testCreate
     */
    public function testInsertCoin(Coin $coin)
    {
        $coin->increase(Quantity::fromInteger(1));
        $this->assertEquals(11, $coin->getQuantity()->count());
    }

    /**
     * @param Coin $coin
     *
     * @depends clone testCreate
     */
    public function testReturnCoin(Coin $coin)
    {
        $coin->decrease(Quantity::fromInteger(1));
        $this->assertEquals(9, $coin->getQuantity()->count());
    }
}

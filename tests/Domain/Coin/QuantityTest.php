<?php

declare(strict_types=1);

namespace VendingMachine\Domain\Coin;

use LogicException;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class QuantityTest extends TestCase
{
    public function testCreate(): Quantity
    {
        $quantity = Quantity::fromInteger(10);
        $this->assertInstanceOf(Quantity::class, $quantity);

        return $quantity;
    }

    public function testTryCreateWithNegativeValue()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectErrorMessage('Coin quantity must be equal or greater than zero.');
        Quantity::fromInteger(-1);
    }

    /**
     * @param Quantity $quantity
     *
     * @depends testCreate
     */
    public function testGetter(Quantity $quantity)
    {
        $this->assertEquals(10, $quantity->count());
    }

    /**
     * @param Quantity $quantity
     *
     * @depends testCreate
     */
    public function testAddValue(Quantity $quantity)
    {
        $this->assertEquals(11, $quantity->add(Quantity::fromInteger(1))->count());
    }

    /**
     * @param Quantity $quantity
     *
     * @depends testCreate
     */
    public function testSubValue(Quantity $quantity)
    {
        $this->assertEquals(9, $quantity->sub(Quantity::fromInteger(1))->count());
    }

    /**
     * @param Quantity $quantity
     *
     * @depends testCreate
     */
    public function testSubValueGreaterThanAllowed(Quantity $quantity)
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Coin quantity must not be less than zero.');
        $quantity->sub(Quantity::fromInteger(11))->count();
    }
}

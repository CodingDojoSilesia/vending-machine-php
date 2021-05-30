<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testCreate(): Money
    {
        $money = Money::USD(100);
        $this->assertInstanceOf(Money::class, $money);

        return $money;
    }

    /**
     * @depends testCreate
     *
     * @param Money $money
     */
    public function testGetters(Money $money)
    {
        $this->assertEquals(100, $money->getAmount());
        $this->assertEquals('USD', $money->getCurrency());
    }

    public function testTryCreateWithNegativeAmount()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectErrorMessage('The value of money cannot be negative.');
        Money::USD(-100);
    }

    public function testCreateWithZeroAmount()
    {
        $money = Money::USD(0);
        $this->assertInstanceOf(Money::class, $money);
        $this->assertEquals(0, $money->getAmount());
    }

    public function testTryCreateWithInvalidCurrency()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectErrorMessage('Illegal currency "PLN".');
        Money::PLN(100);
    }

    /**
     * @param Money $money
     *
     * @depends clone testCreate
     */
    public function testAdd(Money $money)
    {
        $result = $money->add(Money::USD(24));
        $this->assertInstanceOf(Money::class, $result);
        $this->assertEquals(124, $result->getAmount());
        $this->assertEquals('USD', $result->getCurrency());
    }

    /**
     * @param Money $money
     *
     * @depends clone testCreate
     */
    public function testSub(Money $money)
    {
        $result = $money->sub(Money::USD(24));
        $this->assertInstanceOf(Money::class, $result);
        $this->assertEquals(76, $result->getAmount());
        $this->assertEquals('USD', $result->getCurrency());
    }

    /**
     * @param Money $money
     *
     * @depends clone testCreate
     */
    public function testMultiply(Money $money)
    {
        $result = $money->multiply(Quantity::fromInteger(2));
        $this->assertInstanceOf(Money::class, $result);
        $this->assertEquals(200, $result->getAmount());
        $this->assertEquals('USD', $result->getCurrency());
    }

    /**
     * @param Money $money
     *
     * @depends clone testCreate
     */
    public function testTrySubGreaterAmount(Money $money)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectErrorMessage('The subtracted amount cannot be greater than the present amount.');
        $money->sub(Money::USD(101));
    }
}

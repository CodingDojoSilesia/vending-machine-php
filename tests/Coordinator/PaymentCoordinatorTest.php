<?php

declare(strict_types=1);

namespace Tests\Coordinator;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use VendingMachine\Coordinator\PaymentCoordinator;
use VendingMachine\Model\Dime;
use VendingMachine\Model\Quarter;

class PaymentCoordinatorTest extends TestCase
{
    private PaymentCoordinator $paymentCoordinator;

    protected function setUp(): void
    {
        $this->paymentCoordinator = new PaymentCoordinator();
    }

    public function testShouldNotReturnAnyRest(): void
    {
        $rest = $this->paymentCoordinator->pay(100, 100);

        self::assertEquals(0, $rest->count());
        self::assertEquals([], $rest->money());
    }

    public function testShouldReturnRestInTwoQuarter(): void
    {
        $rest = $this->paymentCoordinator->pay(100, 50);

        self::assertEquals(50, $rest->count());
        self::assertEquals(
            [
                new Quarter(),
                new Quarter()
            ],
            $rest->money()
        );
    }

    public function testShouldReturnRestInTwoDime(): void
    {
        $rest = $this->paymentCoordinator->pay(70, 50);

        self::assertEquals(20, $rest->count());
        self::assertEquals(
            [
                new Dime(),
                new Dime()
            ],
            $rest->money()
        );
    }

    public function testShouldReturnRestInQuarterAndDime(): void
    {
        $rest = $this->paymentCoordinator->pay(100, 65);

        self::assertEquals(35, $rest->count());
        self::assertEquals(
            [
                new Quarter(),
                new Dime()
            ],
            $rest->money()
        );
    }

    public function testTryToPayForProductWithoutAnyMoney(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->paymentCoordinator->pay(0, 65);
    }

    public function testTryPayForProductWithNotEnoughMoney(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->paymentCoordinator->pay(10, 65);
    }
}

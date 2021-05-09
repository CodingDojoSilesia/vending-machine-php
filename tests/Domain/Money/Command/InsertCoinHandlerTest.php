<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Money\Command;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Money\Coin;
use VendingMachine\Domain\Money\CoinRepository;
use VendingMachine\Domain\Money\Exception\CoinNotFoundException;
use VendingMachine\Domain\Money\Factory\MoneyFactory;
use VendingMachine\Domain\Money\Quantity;
use VendingMachine\Domain\Money\ShortCode;

class InsertCoinHandlerTest extends TestCase
{
    /**
     * @var CoinRepository|MockObject
     */
    private CoinRepository    $repository;
    private InsertCoinHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->getMockForAbstractClass(CoinRepository::class);
        $this->handler    = new InsertCoinHandler($this->repository);
    }

    public function testCoinNotExists()
    {
        $this->expectException(CoinNotFoundException::class);
        $this->expectErrorMessage('Coin with shortcode "D" cannot be found.');
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(10);
        $this->repository->method('findByShortCode')
            ->with($shortCode)
            ->willReturn(null);

        $this->handler->handle(InsertCoin::withData($shortCode->getCode(), $quantity->getValue()));
    }

    public function testInsertCoin()
    {
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(10);
        $coin      = Coin::withData($shortCode, $quantity);
        $this->repository->method('findByShortCode')->with($shortCode)->willReturn($coin);
        $this->repository->expects($this->once())->method('save')->with($coin);
        $this->handler->handle(InsertCoin::withData($shortCode->getCode(), $quantity->getValue()));
    }
}

<?php
declare(strict_types=1);

namespace VendingMachine\Application\Coin\Handler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VendingMachine\Application\Coin\Command\InsertCoin;
use VendingMachine\Domain\Coin\Coin;
use VendingMachine\Domain\Coin\CoinRepository;
use VendingMachine\Domain\Coin\Exception\CoinNotFoundException;
use VendingMachine\Domain\Coin\Factory\MoneyFactory;
use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;

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

<?php
declare(strict_types=1);

namespace VendingMachine\Application\Coin\Handler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VendingMachine\Application\Coin\Command\ReturnCoin;
use VendingMachine\Domain\Coin\Coin;
use VendingMachine\Domain\Coin\CoinRepository;
use VendingMachine\Domain\Coin\Exception\CoinNotFoundException;
use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;

class ReturnCoinHandlerTest extends TestCase
{
    /**
     * @var CoinRepository|MockObject
     */
    private CoinRepository    $repository;
    private ReturnCoinHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->getMockForAbstractClass(CoinRepository::class);
        $this->handler    = new ReturnCoinHandler($this->repository);
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

        $this->handler->handle(ReturnCoin::withData($shortCode->getCode(), $quantity->getValue()));
    }

    public function testReturnCoin()
    {
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(10);
        $coin      = Coin::withData($shortCode, $quantity);
        $this->repository->method('findByShortCode')->with($shortCode)->willReturn($coin);
        $this->repository->expects($this->once())->method('save')->with($coin);
        $this->handler->handle(ReturnCoin::withData($shortCode->getCode(), $quantity->getValue()));
    }
}

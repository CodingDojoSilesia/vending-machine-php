<?php
declare(strict_types=1);

namespace VendingMachine\Application\Handler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VendingMachine\Application\Command\CreateCoin;
use VendingMachine\Domain\Coin\Coin;
use VendingMachine\Domain\Coin\CoinRepository;
use VendingMachine\Domain\Coin\Exception\CoinAlreadyExist;
use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;

class CreateCoinHandlerTest extends TestCase
{
    /**
     * @var CoinRepository|MockObject
     */
    private CoinRepository    $repository;
    private CreateCoinHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->getMockForAbstractClass(CoinRepository::class);
        $this->handler    = new CreateCoinHandler($this->repository);
    }

    public function testCoinExist()
    {
        $this->expectException(CoinAlreadyExist::class);
        $this->expectErrorMessage('Coin with shortcode "D" already exists.');
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(10);
        $this->repository->method('findByShortCode')
            ->with($shortCode)
            ->willReturn(Coin::withData($shortCode, $quantity));
        $this->handler->handle(CreateCoin::withData($shortCode->getCode(), $quantity->getValue()));
    }

    public function testCreateCoin()
    {
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(10);
        $coin      = Coin::withData($shortCode, $quantity);
        $this->repository->method('findByShortCode')->with($shortCode)->willReturn(null);
        $this->repository->expects($this->once())->method('save')->with($coin);
        $this->handler->handle(CreateCoin::withData($shortCode->getCode(), $quantity->getValue()));
    }
}

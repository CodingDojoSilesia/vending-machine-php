<?php
declare(strict_types=1);

namespace VendingMachine\Infrastructure\Repository;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Coin\Coin;
use VendingMachine\Domain\Coin\CoinRepository;
use VendingMachine\Domain\Coin\Money;
use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;

class InMemoryCoinRepositoryTest extends TestCase
{
    private CoinRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new InMemoryCoinRepository();
    }

    public function testNotFoundCoin()
    {
        $this->assertNull($this->repository->findByShortCode(ShortCode::fromString('N')));
    }

    public function testFoundCoin()
    {
        $this->repository->save(Coin::withData(ShortCode::fromString('Q'), Quantity::fromInteger(10)));

        $coin = $this->repository->findByShortCode(ShortCode::fromString('Q'));
        $this->assertInstanceOf(Coin::class, $coin);
        $shortCode = $coin->getShortCode();
        $amount    = $coin->getAmount();
        $quantity  = $coin->getQuantity();
        $this->assertInstanceOf(ShortCode::class, $shortCode);
        $this->assertInstanceOf(Money::class, $amount);
        $this->assertInstanceOf(Quantity::class, $quantity);
        $this->assertEquals('Q', $shortCode->getCode());
        $this->assertEquals(25, $amount->getAmount());
        $this->assertEquals(10, $quantity->getValue());
    }
}

<?php

declare(strict_types=1);

namespace Tests\VendingMachine;

use LogicException;
use PHPUnit\Framework\TestCase;
use VendingMachine\Item\ItemA;
use VendingMachine\Item\ItemB;
use VendingMachine\Model\Dime;
use VendingMachine\Model\Quarter;
use VendingMachine\Repository\InMemoryItemRepository;
use VendingMachine\Repository\ItemRepository;
use VendingMachine\Util\ConsoleInputParser;
use VendingMachine\VendingMachine;

final class VendingMachineTest extends TestCase
{
    private VendingMachine $vendingMachine;

    public function setUp(): void
    {
        $itemRepositoryMock = $this->getMockBuilder(ItemRepository::class)->getMock();

        $this->vendingMachine = new VendingMachine($itemRepositoryMock, new ConsoleInputParser());
    }

    public function testShouldThrowAnExceptionWhenNoActionFound(): void
    {
        $this->expectException(LogicException::class);

        $this->vendingMachine->execute('test');
    }

    public function testShouldOrderProductAndSpendAllMoney(): void
    {
        $repository = new InMemoryItemRepository();
        $repository->add(new ItemB());

        $vendingMachine = new VendingMachine($repository, new ConsoleInputParser());

        $response = $vendingMachine->execute('Q, Q, Q, Q, GET-B');

        self::assertEquals(0, $response->rest()->count());
        self::assertEquals('B', $response->getOutput());
    }

    public function testShouldOrderProductAndGetRest(): void
    {
        $repository = new InMemoryItemRepository();
        $repository->add(new ItemA());

        $vendingMachine = new VendingMachine($repository, new ConsoleInputParser());

        $response = $vendingMachine->execute('Q, Q, Q, Q, GET-A');

        self::assertEquals(35, $response->rest()->count());
        self::assertEquals([
            new Quarter(),
            new Dime(),
        ], $response->rest()->money());
        self::assertEquals('A', $response->getOutput());
    }

    public function testShouldThrowExceptionWhileOrderingProductIsNotAvailable(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $repository = new InMemoryItemRepository();
        $repository->add(new ItemA());

        $vendingMachine = new VendingMachine($repository, new ConsoleInputParser());

        $vendingMachine->execute('Q, Q, Q, Q, GET-B');
    }

    public function testShouldOrderUsingDollarAndGetRestWithOutExactChange(): void
    {
        $repository = new InMemoryItemRepository();
        $repository->add(new ItemA());

        $vendingMachine = new VendingMachine($repository, new ConsoleInputParser());

        $response = $vendingMachine->execute('DOLLAR, GET-A');

        self::assertEquals(35, $response->rest()->count());
        self::assertEquals([
            new Quarter(),
            new Dime(),
        ], $response->rest()->money());
        self::assertEquals('A', $response->getOutput());
    }

}

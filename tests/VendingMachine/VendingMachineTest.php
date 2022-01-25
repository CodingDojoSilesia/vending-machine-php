<?php

declare(strict_types=1);

namespace Tests\VendingMachine;

use LogicException;
use PHPUnit\Framework\TestCase;
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


}

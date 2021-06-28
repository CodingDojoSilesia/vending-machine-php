<?php

declare(strict_types=1);

namespace VendingMachine\Application\Kernel;

use PHPUnit\Framework\TestCase;
use VendingMachine\Application\Bus\CommandBus;
use VendingMachine\Application\Bus\QueryBus;
use VendingMachine\Domain\Shared\Command\CommandInterface;
use VendingMachine\Domain\Shared\Query\QueryInterface;

class VendingKernelTest extends TestCase
{
    private CommandBus    $commandBus;
    private QueryBus      $queryBus;
    private VendingKernel $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = $this->getMockBuilder(CommandBus::class)->getMock();
        $this->queryBus   = $this->getMockBuilder(QueryBus::class)->getMock();
        $this->service    = new VendingKernel($this->commandBus, $this->queryBus);
    }

    public function testHandleCommand()
    {
        $command = new class() implements CommandInterface {
        };
        $this->commandBus->expects($this->once())->method('dispatch')->with($command);
        $this->service->handle($command);
    }

    public function testHandleQuery()
    {
        $query = new class() implements QueryInterface {
        };
        $this->queryBus->expects($this->once())->method('dispatch')->with($query);
        $this->service->query($query);
    }
}

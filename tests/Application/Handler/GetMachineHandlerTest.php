<?php

declare(strict_types=1);

namespace VendingMachine\Application\Handler;

use PHPUnit\Framework\TestCase;
use VendingMachine\Application\Projection\MachineFinder;
use VendingMachine\Domain\Machine\View\Machine;
use VendingMachine\Domain\Machine\Query\GetMachine;

class GetMachineHandlerTest extends TestCase
{
    private MachineFinder     $finder;
    private GetMachineHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->finder  = $this->getMockForAbstractClass(MachineFinder::class);
        $this->handler = new GetMachineHandler($this->finder);
    }

    public function testGetMachine()
    {
        $machine = new Machine(10,0,[]);
        $this->finder->expects($this->once())->method('findOne')->willReturn($machine);
        $this->assertEquals($machine, $this->handler->handle(new GetMachine()));
    }
}

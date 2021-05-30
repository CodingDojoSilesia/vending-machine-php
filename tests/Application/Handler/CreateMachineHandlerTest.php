<?php

namespace VendingMachine\Application\Handler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Machine\Command\CreateMachine;
use VendingMachine\Domain\Machine\Exception\MachineAlreadyExists;
use VendingMachine\Domain\Machine\Machine;
use VendingMachine\Domain\Machine\MachineRepository;

class CreateMachineHandlerTest extends TestCase
{
    /**
     * @var MachineRepository|MockObject
     */
    private MachineRepository $repository;
    private CreateMachineHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->getMockForAbstractClass(MachineRepository::class);
        $this->handler    = new CreateMachineHandler($this->repository);
    }

    public function testMachineExists()
    {
        $this->expectException(MachineAlreadyExists::class);
        $this->repository->method('findOne')->willReturn(new Machine());
        $this->handler->handle(new CreateMachine());
    }

    public function testCreateMachine()
    {
        $this->repository->method('findOne')->willReturn(null);
        $this->repository->expects($this->once())->method('save')->with($this->isInstanceOf(Machine::class));
        $this->handler->handle(new CreateMachine());
    }
}

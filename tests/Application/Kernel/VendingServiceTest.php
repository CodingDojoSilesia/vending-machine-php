<?php
declare(strict_types=1);

namespace VendingMachine\Application\Kernel;

use PHPUnit\Framework\TestCase;
use VendingMachine\Application\ServiceBus\MessageBus;

class VendingServiceTest extends TestCase
{
    private MessageBus    $commandBus;
    private VendingKernel $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = $this->getMockForAbstractClass(MessageBus::class);
        $this->service = new VendingKernel($this->commandBus);
    }

    public function testHandle()
    {
        $command = new class() {};
        $this->commandBus->expects($this->once())->method('dispatch')->with($command);
        $this->service->handle($command);
    }
}

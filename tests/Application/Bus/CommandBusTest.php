<?php
declare(strict_types=1);

namespace VendingMachine\Application\Bus;

use PHPUnit\Framework\TestCase;

class CommandBusTest extends TestCase
{
    private MessageBus $commandBus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = new CommandBus();
    }

    public function testDispatch()
    {
        $command = new class('Test') {
            private string $name;

            public function __construct(string $name)
            {
                $this->name = $name;
            }

            public function getName(): string
            {
                return $this->name;
            }
        };

        $handler = new class() {
            public function handle(object $command) {
                echo $command->getName();
            }
        };

        $this->expectOutputString('Test');
        $this->commandBus->attach(get_class($command), [$handler, 'handle']);
        $this->commandBus->dispatch($command);
    }
}

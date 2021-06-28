<?php

declare(strict_types=1);

namespace VendingMachine\Application\Bus;

use stdClass;
use PHPUnit\Framework\TestCase;

class QueryBusTest extends TestCase
{
    private QueryBus $queryBus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->queryBus = new QueryBus();
    }

    public function testDispatch()
    {
        $query = new class('Test') {
            private stdClass $object;

            public function __construct(string $name)
            {
                $this->object       = new stdClass();
                $this->object->name = $name;
            }

            public function getObject(): stdClass
            {
                return $this->object;
            }
        };

        $handler = new class() {
            public function handle(object $command) {
                return $command->getObject();
            }
        };

        $this->queryBus->attach(get_class($query), [$handler, 'handle']);
        $result = $this->queryBus->dispatch($query);
        $this->assertInstanceOf(stdClass::class, $result);
        $this->assertEquals('Test', $result->name);
    }
}

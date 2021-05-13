<?php
declare(strict_types=1);

namespace VendingMachine\Application\Bus;

abstract class MessageBus
{
    protected array $handlers = [];
    abstract public function attach(string $eventName, callable $handler);
    abstract public function dispatch(object $message);
}

<?php

declare(strict_types=1);

namespace VendingMachine\Application\Bus;

abstract class MessageBus
{
    protected const TYPE_COMMAND = 'command';
    protected const TYPE_QUERY   = 'query';
    protected array $handlers = [];

    abstract protected function messageType(): string;
    abstract public function dispatch(object $message);

    public function attach(string $eventName, callable $handler)
    {
        $this->handlers[$this->messageType()][$eventName] = $handler;
    }
}

<?php
declare(strict_types=1);

namespace VendingMachine\Application\ServiceBus;

class CommandBus extends MessageBus
{
    public function attach(string $eventName, callable $handler)
    {
        $this->handlers[$eventName] = $handler;
    }

    public function dispatch(object $message)
    {
        call_user_func($this->handlers[get_class($message)], $message);
    }
}

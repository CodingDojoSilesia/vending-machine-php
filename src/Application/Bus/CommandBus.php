<?php
declare(strict_types=1);

namespace VendingMachine\Application\Bus;

class CommandBus extends MessageBus
{
    protected function messageType(): string
    {
        return self::TYPE_COMMAND;
    }

    public function dispatch(object $message): void
    {
        call_user_func($this->handlers[$this->messageType()][get_class($message)], $message);
    }
}

<?php
declare(strict_types=1);

namespace VendingMachine\Application\Bus;

class QueryBus extends MessageBus
{
    protected function messageType(): string
    {
        return self::TYPE_QUERY;
    }

    public function dispatch(object $message): object
    {
        return call_user_func($this->handlers[$this->messageType()][get_class($message)], $message);
    }
}

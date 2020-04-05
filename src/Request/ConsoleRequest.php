<?php


namespace VendingMachine\Request;


use VendingMachine\Model\Money;

class ConsoleRequest
{
    /**
     * @var array Money[]
     */
    private array $money = [];

    /**
     * @var string
     */
    private string $action;

    public function __construct(string $action)
    {
        $this->action = $action;
    }

    public function addMoney(Money $money)
    {
        $this->money[] = $money;
    }

    public function assertAction(string $action)
    {

    }

    public function action(): string 
    {
        return $this->action;
    }
}

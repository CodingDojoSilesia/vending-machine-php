<?php

declare(strict_types=1);

namespace VendingMachine\Request;

use VendingMachine\Model\Money;

class ConsoleRequest implements Request
{
    /**
     * @var array Money[]
     */
    private array $money = [];

    /**
     * @var string
     */
    protected string $action;

    public function __construct(string $action)
    {
        $this->assertAction($action);

        $this->action = $action;
    }

    /**
     * @param Money $money
     */
    public function addMoney(Money $money): void
    {
        $this->money[] = $money;
    }

    /**
     * @param Money[]
     */
    public function setMoney(array $moneys): void
    {
        $this->money = $moneys;
    }

    /**
     * @param string $action
     */
    public function assertAction(string $action): void
    {
        if (!preg_match('/GET-[A-C]/', $action)) {
            throw new \InvalidArgumentException('Invalid action name!');
        }
    }

    public function action(): string 
    {
        return $this->action;
    }

    public function money(): array
    {
        return $this->money;
    }
}

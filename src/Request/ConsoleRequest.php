<?php

declare(strict_types=1);

namespace VendingMachine\Request;

use VendingMachine\Model\Money;
use VendingMachine\Model\MoneyCollection;

class ConsoleRequest implements Request
{
    private MoneyCollection $moneys;

    /**
     * @var string
     */
    protected string $action;

    public function __construct(string $action)
    {
        $this->assertAction($action);

        $this->action = $action;
        $this->moneys = new MoneyCollection([]);
    }

    /**
     * @param Money $money
     */
    public function addMoney(Money $money): void
    {
        $this->moneys->addMoney($money);
    }

    /**
     * @param MoneyCollection $moneys
     */
    public function setMoney(MoneyCollection $moneys): void
    {
        $this->moneys = $moneys;
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
        return $this->moneys->money();
    }

    public function moneyCollection(): MoneyCollection
    {
        return $this->moneys;
    }
}

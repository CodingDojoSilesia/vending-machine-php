<?php

declare(strict_types=1);

namespace VendingMachine\Request;

use VendingMachine\Model\Money;
use VendingMachine\Model\MoneyCollection;

class ConsoleRequest implements Request
{
    private MoneyCollection $moneys;

    protected string $action;

    protected string $productShortCode;

    public function __construct(string $action)
    {
        $this->assertAction($action);

        $this->action = $action;
        $this->moneys = new MoneyCollection([]);
    }

    public function addMoney(Money $money): void
    {
        $this->moneys->addMoney($money);
    }

    public function setMoney(MoneyCollection $moneys): void
    {
        $this->moneys = $moneys;
    }

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

    public function setProductShortCode(string $productShortCode): void
    {
        $this->productShortCode = $productShortCode;
    }

    public function productShortCode(): string
    {
        return $this->productShortCode;
    }
}

<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Machine;

use VendingMachine\Domain\AggregateRoot;
use VendingMachine\Domain\Coin\Money;
use VendingMachine\Domain\Machine\Event\MachineWasCreated;

class Machine extends AggregateRoot
{
    private array $coins;
    private Money $totalBalance;
    private Money $clientBalance;


    public function __construct()
    {
        $this->record(new MachineWasCreated());
    }

    protected function apply(object $event): void
    {
        switch (get_class($event)) {
            case MachineWasCreated::class:
                $this->coins         = [];
                $this->totalBalance  = Money::USD(0);
                $this->clientBalance = Money::USD(0);
                break;
        }
    }
}

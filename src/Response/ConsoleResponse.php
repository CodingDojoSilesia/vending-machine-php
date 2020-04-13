<?php

declare(strict_types=1);

namespace VendingMachine\Response;

use VendingMachine\Model\MoneyCollection;

class ConsoleResponse
{
    /**
     * @var MoneyCollection
     */
    private MoneyCollection $rest;

    /**
     * @param MoneyCollection $rest
     * @return ConsoleResponse
     */
    public function setRest(MoneyCollection $rest): ConsoleResponse
    {
        $this->rest = $rest;
        return $this;
    }

    /**
     * @return MoneyCollection
     */
    public function rest(): MoneyCollection
    {
        return $this->rest;
    }

    public function getOutput(): string
    {
        return "resztaaa! \n";
    }
}

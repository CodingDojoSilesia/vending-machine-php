<?php declare(strict_types=1);

namespace VendingMachine\Command;

use VendingMachine\Request\CoinReturnRequest;
use VendingMachine\Response\ConsoleResponse;

class CoinReturnCommand
{
    public function execute(CoinReturnRequest $request): ConsoleResponse
    {
        return (new ConsoleResponse)->setRest($request->moneyCollection());
    }
}
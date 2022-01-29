<?php declare(strict_types=1);

namespace VendingMachine\Command;

use VendingMachine\Request\CoinReturnRequest;
use VendingMachine\Response\CoinReturnConsoleResponse;
use VendingMachine\Response\Response;

class CoinReturnCommand
{
    public function execute(CoinReturnRequest $request): Response
    {
        return (new CoinReturnConsoleResponse($request->moneyCollection()));
    }
}
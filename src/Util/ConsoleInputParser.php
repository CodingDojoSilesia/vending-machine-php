<?php

declare(strict_types=1);

namespace VendingMachine\Util;

use VendingMachine\Model\AvailableMoney;
use VendingMachine\Model\Money;
use VendingMachine\Model\MoneyCollection;
use VendingMachine\Request\ConsoleRequest;

class ConsoleInputParser implements InputParser
{
    public function parse(string $input): ConsoleRequest
    {
        $parameters = $this->splitParameters($input);

        $action = $this->filterAction($parameters);
        // code smelling
        $consoleRequest = new ConsoleRequest($action);

        $money = $this->filterMoney($parameters);
        // code smelling
        $consoleRequest->setMoney(new MoneyCollection($money));

        $consoleRequest->setProductShortCode($this->filterProductCode($action));

        return $consoleRequest;
    }

    private function splitParameters(string $input): array
    {
        $request = explode(',', $input);

        return array_map(static function ($element) {
            return trim($element);
        }, $request);
    }

    private function filterAction(array $parameters): string
    {
        $action = null;
        // array_filter
        /** @var string $parameter */
        foreach ($parameters as $parameter) {
            // filter action - set to ConsoleRequest
            if (preg_match('/GET-[A-C]/', $parameter)) {
                $action = $parameter;
            }
        }

        // array_filter
        foreach ($parameters as $parameter) {
            // filter action - set to ConsoleRequest
            if (str_contains($parameter, 'COIN-RETURN')) {
                $action = $parameter;
            }
        }

        if (!$action) {
            throw new \LogicException(sprintf('No action found for %s', ...$parameters));
        }

        return $action;
    }

    public function filterMoney(array $parameters): array
    {
        $money = [];
        /** @var string $parameter */
        foreach ($parameters as $parameter) {
            $results = array_filter(AvailableMoney::getMoney(), static function (Money $money) use ($parameter) {
                return $money->shortCode() === $parameter;
            });

            if (count($results) === 1) {
                $money[] = reset($results);
            }
        }

        if (empty($money)) {
            throw new \InvalidArgumentException('Any money throw into vending machine!');
        }

        return $money;
    }

    private function filterProductCode(string $action): string
    {
        return explode('-', $action)[1];
    }
}

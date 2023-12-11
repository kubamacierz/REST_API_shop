<?php

namespace App\Collector;

use Doctrine\Common\Collections\Collection;

final class TotalGrossPriceCalculator implements TotalCalculatorInterface
{
    private $flag = 'totalGrossPrice';

    public function calculate(Collection $orderItems): float
    {
        $totalPrice = 0;

        foreach ($orderItems as $orderItem) {
            $totalPrice += $orderItem->getProduct()->getPrice() * $orderItem->getQuantity() * 1.23;
        }

        return $totalPrice;
    }

    public function getFlag(): string
    {
        return $this->flag;
    }
}
<?php

namespace App\Collector;

use Doctrine\Common\Collections\Collection;

final class TotalNetPriceCalculator implements TotalCalculatorInterface
{
    private $flag = 'totalNetPrice';

    public function calculate(Collection $orderItems): float
    {
        $totalPrice = 0;

        foreach ($orderItems as $orderItem) {
            $totalPrice += $orderItem->getProduct()->getPrice() * $orderItem->getQuantity();
        }

        return $totalPrice;
    }

    public function getFlag(): string
    {
        return $this->flag;
    }
}
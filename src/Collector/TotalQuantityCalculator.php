<?php

namespace App\Collector;

use Doctrine\Common\Collections\Collection;

final class TotalQuantityCalculator implements TotalCalculatorInterface
{
    private $flag = 'totalQuantity';

    public function calculate(Collection $orderItems): int
    {
        $totalQuantity = 0;

        foreach ($orderItems as $orderItem) {
            $totalQuantity += $orderItem->getQuantity();
        }

        return $totalQuantity;
    }

    public function getFlag(): string
    {
        return $this->flag;
    }
}
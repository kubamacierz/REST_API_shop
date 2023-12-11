<?php

namespace App\Collector;

use Doctrine\Common\Collections\Collection;

final class VatCalculator implements TotalCalculatorInterface
{
    private $flag = 'totalVat';

    public function calculate(Collection $orderItems): float
    {
        $totalVat = 0;

        foreach ($orderItems as $orderItem) {
            $price = $orderItem->getProduct()->getPrice();
            $totalVat += (($price * 1.23) - $price) * $orderItem->getQuantity(); 
        }

        return $totalVat;
    }

    public function getFlag(): string
    {
        return $this->flag;
    }

}
<?php

namespace App\Collector;

use Doctrine\Common\Collections\Collection;

class TotalCalculatorCollector
{
    /** @var TotalCalculatorInterface[] $totalCalculators */
    private $totalCalculators = [];


    public function __construct(array $priceCalculators)
    {
        $this->totalCalculators = $priceCalculators;
    }

    public function calculate(Collection $orderItems)
    {
        $totalValues = [];

        foreach ($this->totalCalculators as $totalCalculator) {
            $totalValues[$totalCalculator->getFlag()] = $totalCalculator->calculate($orderItems);
        }

        return $totalValues;
    }
}




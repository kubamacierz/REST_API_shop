<?php

namespace App\Collector;

use Doctrine\Common\Collections\Collection;

interface TotalCalculatorInterface
{
    public function calculate(Collection $orderItems): mixed;

    public function getFlag(): string;
}
<?php

namespace App\Service;

use Doctrine\Common\Collections\Collection;

class TotalPriceService
{
    /**
     * Calculates the total price for selected quantity of products.
     * 
     * @return float
     */
    public function getTotalPrice (float $price, int $quantity): float
    {
        return $price * $quantity;
    }

    public function getTotalPriceForAllProducts(Collection $items): float
    {
        $total = 0;

        foreach ($items as $item) {
            $total += self::getTotalPrice($item->getProduct()->getPrice(), $item->getQuantity());
            // $total += $tsp->getTotalPrice($item->getProduct()->getPrice(), $item->getQuantity());
        }
        return $total;
    }
}
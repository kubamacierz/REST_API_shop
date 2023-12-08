<?php

namespace App\Tests\Service;

use App\Entity\OrderItem;
use PHPUnit\Framework\TestCase;
use App\Entity\Product;
use App\Service\TotalPriceService;
use Doctrine\Common\Collections\ArrayCollection;

class TotalPriceServiceTest extends TestCase
{

    public function testTotalPrice()
    {
        $tps = new TotalPriceService();

        $product1 = new Product();
        $product1->setName('p1');
        $product1->setDescription('desc1');
        $product1->setPrice(5.5);

        $product2 = new Product();
        $product2->setName('p2');
        $product2->setDescription('desc2');
        $product2->setPrice(3);

        $item1 = new OrderItem($product1);
        $item1->setQuantity(3);

        $item2 = new OrderItem($product2);
        $item2->setQuantity(2);

        $totalPrice1 = $tps->getTotalPrice($product1->getPrice(), $item1->getQuantity());
        // $totalPrice2 = $tps->getTotalPrice($product2->getPrice(), $item2->getQuantity());

        $this->assertEquals(16.5, $totalPrice1);
    }
}
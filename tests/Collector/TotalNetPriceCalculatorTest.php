<?php

namespace App\Tests\Collector;

use App\Collector\TotalNetPriceCalculator;
use App\Entity\OrderItem;
use App\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TotalNetPriceCalculatorTest extends KernelTestCase
{
    public function testCalculatePrice()
    {
        $collection = new ArrayCollection();
        
        $item1 = new OrderItem();
        $product1 = new Product();
        $product1->setPrice(250);
        $item1->setProduct($product1);
        $item1->setQuantity(2);
        $collection[] = $item1;

        $item2 = new OrderItem();
        $product2 = new Product();
        $product2->setPrice(500);
        $item2->setProduct($product2);
        $item2->setQuantity(1);
        $collection[] = $item2;

        $calculator = new TotalNetPriceCalculator();
        
        $expected = $calculator->calculate($collection);
        
        $this->assertEquals($expected, 1000);
    }
}
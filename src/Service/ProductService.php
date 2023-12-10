<?php

namespace App\Service;

use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV7;

class ProductService
{
    private ProductRepository $productRepository;

    private OrderRepository $orderRepository;

    public function __construct(
        ProductRepository $pr,
        OrderRepository $or
    )
    {
        $this->productRepository = $pr;
        $this->orderRepository = $or;
    }

    public function findProductsByIds(string $json)
    {
        $result = [];

        // $ids = [];

        $items = json_decode($json);

        foreach ($items as $item) {
            // $ids[] = $item->id;
            /** @var Uuid $id */
            $id = $item->id;
            $product = $this->productRepository->find($id);
            $result[] = $product;
        }

        if (count($result) !== count($items)) {
            // Error
        }

        return $result;
    }
}
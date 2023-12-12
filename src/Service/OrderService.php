<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Exception;

class OrderService
{
    private ProductRepository $productRepository;

    private EntityManagerInterface $entityManager;

    public function __construct(
        ProductRepository $pr,
        EntityManagerInterface $em
    )
    {
        $this->productRepository = $pr;
        $this->entityManager = $em;
    }

    public function createOrder(array $orderItems)
    {
        $ids = [];

        $quantityById = [];

        foreach($orderItems as $orderItem) {
            $ids[] = $orderItem['id'];
            $quantityById[$orderItem['id']] = $orderItem['quantity'];
        }

        $products = $this->productRepository->findProductsByIds($ids);

        if (count($ids) !== count($products)) {
            throw new Exception('Duplicate product in order is not allowed!');
        }

        $order = new Order();
        $order->setCreatedAt(new DateTime());
        $order->setUpdatedAt(new DateTime());

        foreach ($products as $product) {
            $orderedItem = new OrderItem();
            $orderedItem->setProduct($product);
            $orderedItem->setQuantity($quantityById[$product->getId()->toRfc4122()]);
            $order->addItem($orderedItem);
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }
}
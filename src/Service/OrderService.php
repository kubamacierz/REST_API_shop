<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;
use DateTime;

class OrderService
{
    private ProductRepository $productRepository;

    private OrderRepository $orderRepository;

    private EntityManagerInterface $entityManager;

    public function __construct(
        ProductRepository $pr,
        OrderRepository $or,
        EntityManagerInterface $em
    )
    {
        $this->productRepository = $pr;
        $this->orderRepository = $or;
        $this->entityManager = $em;
    }

    public function createOrder(array $orderItems)
    {
        $ids = [];

        // foreach($orderItems as $orderItem)
        // {
        //     $ids[] = $orderItem['id'];
        // }

        $quantityById = [];

        foreach($orderItems as $orderItem)
        {
            $ids[] = $orderItem['id'];
            $quantityById[$orderItem['id']] = $orderItem['qty'];
        }

        // dd($quantityById);

        $products = $this->productRepository->findProductsByIds($ids);
        // $products = $this->productRepository->findBy(['id' => $ids]);

        // dd($products[0]->qty);

        if (count($ids) !== count($products)) {
            return;
        }

        $order = new Order();
        $order->setCreatedAt(new DateTime());
        $order->setUpdatedAt(new DateTime());

        // $this->entityManager->persist($order);
        // $this->entityManager->flush();

        foreach ($products as $product) {
            $orderedItem = new OrderItem();
            $orderedItem->setProduct($product);
            // $orderedItem->setOrderRef($order);
            $orderedItem->setQuantity($quantityById[$product->getId()->toRfc4122()]);
            $order->addItem($orderedItem);

            // $this->entityManager->persist($orderedItem);
            // $this->entityManager->flush();
        }
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
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
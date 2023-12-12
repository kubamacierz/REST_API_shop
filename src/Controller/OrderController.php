<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\OrderService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api')]
class OrderController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/orders/{id}', name: 'order_by_id', methods: 'GET')]
    public function showCartAction(Order $order): JsonResponse
    {
        $response = new JsonResponse($this->serializer->serialize($order, 'json', ['groups' => ['order']]), 200, [], true);

        return $response;
    }

    #[Route('/orders/create', name: 'order_create', methods: ['POST', 'GET'])]
    public function createOrderAction(
        Request $request, 
        OrderService $orderService 
        ): JsonResponse
    {
        $jsonData = json_decode($request->getContent(), true);

        // Check if the JSON data is valid
        if (json_last_error() !== JSON_ERROR_NONE) {
        // Handle the error
            return new JsonResponse(['message' => 'Invalid JSON', 'HTTP code' => JsonResponse::HTTP_BAD_REQUEST]);
        }

        /** @var Order $order */
        $order = $orderService->createOrder($jsonData);

        if (!($order instanceof Order)) {
            return new JsonResponse(['message' => $order, 422]);
        }

        $response = new JsonResponse($this->serializer->serialize($order, 'json', ['groups' => ['order']]), 200, [], true);

        return $response;
    }
}

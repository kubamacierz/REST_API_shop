<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\OrderService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api')]
class OrderController extends AbstractController
{
    // #[Route('/cart', name: 'app_cart')]
    // public function index(): Response
    // {

    //     $response = $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/CartController.php',
    //     ]);

    //     return $response;
    // }

    #[Route('/orders/{id}', name: 'order_by_id', methods: 'GET')]
    public function showCartAction(Order $order): JsonResponse
    {
        return $this->json($order);
    }

    #[Route('/test', methods: ['POST', 'GET'])]
    public function test(Request $request, OrderService $orderService, SerializerInterface $serializer)
    {
        $jsonData = json_decode($request->getContent(), true);

        // Check if the JSON data is valid
        if (json_last_error() !== JSON_ERROR_NONE) {
        // Handle the error appropriately (e.g., return a 400 Bad Request response)
            return new Response('Invalid JSON', Response::HTTP_BAD_REQUEST);
        }


        /** @var Order $order */
        $order = $orderService->createOrder($jsonData);

        if (!($order instanceof Order)) {
            return new JsonResponse(['message' => $order, 422]);
        }

        // dd($serializer->serialize($order, 'json'));


        $response = new JsonResponse($serializer->serialize($order, 'json', ['groups' => ['order']]), 200, [], true);
        // dd($response);

        return $response;

    }
}

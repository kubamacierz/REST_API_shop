<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\OrderService;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function showCartAction(Order $order)
    {
        return $this->json($order);
    }

    #[Route('/test')]
    public function test(OrderService $orderService, SerializerInterface $serializer)
    {
        $payload = '[{"id":"018c49f4-328f-7aea-99eb-7dc599de2eb7", "qty":5}, {"id":"018c4e14-5775-7d57-b013-ef4ad42bc342", "qty":7}]';

          // to do validate json

        $validatedJsonData = json_decode($payload, true);

        // dd($validatedJsonData);

        /** @var Order $order */
        $order = $orderService->createOrder($validatedJsonData);

        if (!($order instanceof Order)) {
            return new JsonResponse(['message' => $order, 422]);
        }

        

        // dd($serializer->serialize($order, 'json'));


        return new JsonResponse($serializer->serialize($order, 'json'));

        
    }
}

<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {

        $response = $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CartController.php',
        ]);

        return $response;
    }
}

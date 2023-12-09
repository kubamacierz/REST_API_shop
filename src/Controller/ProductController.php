<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api')]
class ProductController extends AbstractApiController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $eM)
    {
        $this->em = $eM;
    }


    #[Route('/products', name: 'list_all_products', methods: 'GET')]
    public function indexAction(ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->findAll();

        return $this->json($products);
    }

    #[Route('/products', name: 'create_product', methods: 'POST')]
    public function createAction(Request $request): Response
    {
        $form = $this->buildForm(ProductType::class);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Product $product */
        $product = $form->getData();

        $this->em->persist($product);
        $this->em->flush();

        return $this->respond($product);
    }
}

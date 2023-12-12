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
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api')]
class ProductController extends AbstractApiController
{
    private EntityManagerInterface $em;

    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $eM, SerializerInterface $serializer)
    {
        $this->em = $eM;
        $this->serializer = $serializer;
    }

    #[Route('/products', name: 'list_all_products', methods: 'GET')]
    public function indexAction(ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->findAll();

        $response = new JsonResponse(
            $this->serializer->serialize($products, 'json', ['groups' => ['product']]),
            200, 
            [], 
            true
        );

        return $response;
    }

    #[Route('/products', name: 'create_product', methods: 'POST')]
    public function createAction(Request $request)
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

        $response = new JsonResponse(
            $this->serializer->serialize($product, 'json', ['groups' => ['product']]),
            JsonResponse::HTTP_OK,
            [],
            true
        );

        return $response;
    }
}

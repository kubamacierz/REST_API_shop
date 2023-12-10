<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use DateTime;
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

    #[Route('/test')]
    public function showProductsByIds(ProductService $productService)
    {
        $json = '[{"id":"018c49f4-328f-7aea-99eb-7dc599de2eb7", "qty":5}, {"id":"018c4e14-5775-7d57-b013-ef4ad42bc342", "qty":7}]';
        /** @var Product $product */
        $products = $productService->findProductsByIds($json);

        $jsondecoded = json_decode($json);

        // var_dump($products);

        $order = new Order();
        $order->setCreatedAt(new DateTime());
        $order->setUpdatedAt(new DateTime());

        $this->em->persist($order);
        $this->em->flush();

        $i = 0;
        foreach ($products as $product) {
            $orderItem = new OrderItem();
            $orderItem->setProduct($product);
            $orderItem->setOrderRef($order);
            $orderItem->setQuantity($jsondecoded[$i]->qty);

            $this->em->persist($orderItem);
            $this->em->flush();
            $i++;
        }

        return $this->respond('la');
    }
}

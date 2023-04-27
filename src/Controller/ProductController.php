<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'list_products')]
    public function list(ProductRepository $productRepository): Response
    {
        return $this->render('product/list.html.twig', [
            'products' => $productRepository->findAllVisible(),
        ]);
    }

    #[Route('/products/{id}', name: 'product_details')]
    public function item(Product $product): Response
    {
        return $this->render('product/item.html.twig', [
            'product' => $product
        ]);
    }
}

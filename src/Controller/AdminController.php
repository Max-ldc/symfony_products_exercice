<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/products', name: 'index_crud_products')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('admin/products/{id}', name: 'product_admin')]
    public function item(Product $product): Response
    {
        return $this->render('admin/item.html.twig', [
            'product' => $product
        ]);
    }
}

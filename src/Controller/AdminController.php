<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\AddProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('admin/products/read/{id}', name: 'product_admin')]
    public function item(Product $product): Response
    {
        return $this->render('admin/item.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('admin/products/delete/{id}', name: 'delete_product')]
    public function delete(Product $product, ProductRepository $productRepository): Response
    {
        $productRepository->remove($product, true);
        $this->addFlash('success', 'Produit supprimé');

        return $this->redirectToRoute('index_crud_products');
    }

    #[Route('admin/products/add', name: 'add_product', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product;
        $form = $this->createForm(AddProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Le produit a bien été ajouté');

            return $this->redirectToRoute('index_crud_products');
        }

        return $this->renderForm('admin/create.html.twig', [
            'form' => $form,
        ]);
    }
}

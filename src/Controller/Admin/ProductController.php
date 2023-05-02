<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/products')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'index_crud_products')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/read/{id}', name: 'product_admin')]
    public function item(Product $product): Response
    {
        return $this->render('admin/item.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_product')]
    public function delete(Product $product, ProductRepository $productRepository): Response
    {
        $productRepository->remove($product, true);
        $this->addFlash('success', 'Produit supprimé');

        return $this->redirectToRoute('index_crud_products');
    }

    #[Route('/add', name: 'add_product', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product;
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setDateCreated(new DateTime());
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Le produit a bien été ajouté');

            return $this->redirectToRoute('index_crud_products');
        }

        return $this->renderForm('admin/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_product')]
    public function edit(Product $product, EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'ça marche');
            return $this->redirectToRoute('index_crud_products');
        }

        return $this->renderForm('admin/edit.html.twig', [
            'form' => $form,
        ]);
    }
}

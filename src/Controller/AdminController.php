<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/products', name: 'index_crud_products')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', []);
    }
}

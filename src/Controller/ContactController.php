<?php

namespace App\Controller;

use App\Contact\ContactRequest;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function contact(
        Request $request,
        ContactRequest $contactRequest
    ): Response {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRequest->send($form->getData());
            
            $this->addFlash('success', 'Votre message a bien été envoyé');
            return $this->redirectToRoute('app_index');
        }

        return $this->renderForm('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
}

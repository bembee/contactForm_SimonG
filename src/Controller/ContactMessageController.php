<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Form\ContactMessageType;
use App\Repository\ContactMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact')]
class ContactMessageController extends AbstractController
{
    #[Route('/', name: 'app_contact_message_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContactMessageRepository $contactMessageRepository): Response
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactMessageRepository->save($contactMessage, true);

            return $this->redirectToRoute('app_contact_message_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact_message/contact.html.twig', [
            'contact_message' => $contactMessage,
            'form' => $form,
        ]);
    }
}

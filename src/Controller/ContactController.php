<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, Mail $mail): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', 'Message envoyé, nous vous répondrons dans les plus brefs délais');
            $datas = $form->getData();
            $content = sprintf(
                "De la part de : %s %s <br> Message : %s <br> Email: %s",
                htmlspecialchars($datas['firstname']),
                htmlspecialchars($datas['lastname']),
                nl2br(htmlspecialchars($datas['content'])),
                htmlspecialchars($datas['email'])
            );

            $mail->send(
                'bonnal.tristan91@gmail.com',
                'Tristan',
                'Contact visiteur La Boot\'ique',
                $content
            );

            return $this->redirectToRoute('contact'); // Redirect after form submission
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(), // Use createView() for the form
        ]);
    }
}

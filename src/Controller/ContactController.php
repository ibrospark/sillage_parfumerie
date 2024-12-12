<?php

/// src/Controller/ContactController.php
namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailer, ParameterBagInterface $params)
    {
        // Création du formulaire de contact
        $form = $this->createForm(ContactType::class);

        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des données du formulaire
            $data = $form->getData();

            // Création de l'email
            $email = (new Email())
                ->from($data['email'])
                ->to('ibrospark@live.fr')
                ->subject('Message de contact - ' . $data['subject'])
                ->text($data['message']);

            // Gestion de la pièce jointe (si elle existe)
     // Vérifiez si 'attachment' existe dans le formulaire et si un fichier a été téléchargé
if ($form->has('attachment') && $form->get('attachment')->getData()) {
    // Récupérer les données du fichier
    $attachment = $form->get('attachment')->getData();

    // Déplacer le fichier téléchargé dans un répertoire spécifique
    $uploadDir = $params->get('upload_directory'); // Récupère le répertoire de téléchargement configuré dans services.yaml
    $originalFilename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
    $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII', $originalFilename);
    $newFilename = $safeFilename . '-' . uniqid() . '.' . $attachment->guessExtension();

    // Déplacer le fichier vers le répertoire de stockage
    $attachment->move($uploadDir, $newFilename);

    // Ajouter le fichier joint à l'email
    $email->attachFromPath($uploadDir . '/' . $newFilename);
}


            // Envoi de l'email
            $mailer->send($email);

            // Confirmation à l'utilisateur
            $this->addFlash('success', 'Votre message a été envoyé avec succès.');

            // Redirection après envoi
            return $this->redirectToRoute('contact');
        }

        // Affichage du formulaire
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

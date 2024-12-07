<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Form\FormInterface;

/**
 * Espace membre (sécurisé)
 */
#[IsGranted('ROLE_USER')]
#[Route('/account')]
class AccountController extends AbstractController
{
    #[Route(name: 'account.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }

    #[Route('/password', name: 'account.password.change', methods: ['GET', 'POST'])]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $this->ensureUserIsValid($user);

        $form = $this->createForm(ChangePasswordFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handlePasswordChange($form, $passwordHasher, $em, $user);
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function ensureUserIsValid($user): void
    {
        if (!$user instanceof User) {
            throw new \LogicException('L\'utilisateur doit être une instance de User.');
        }
    }

    private function handlePasswordChange(FormInterface $form, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em, User $user): Response
    {
        $oldPassword = $form->get('old_password')->getData();
        $newPassword = $form->get('plainPassword')->getData();

        // Vérifier si l'ancien mot de passe est correct
        if ($passwordHasher->isPasswordValid($user, $oldPassword)) {
            // Hacher le nouveau mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
            $user->setPassword($hashedPassword);
            $em->flush();

            // Afficher un message de succès
            $this->addFlash('success', 'Mot de passe modifié avec succès !');
            return $this->redirectToRoute('account.index');
        }

        // Afficher un message d'erreur si l'ancien mot de passe est incorrect
        $this->addFlash('error', 'Le mot de passe actuel est incorrect.');
        return $this->redirectToRoute('account.password.change');
    }
}

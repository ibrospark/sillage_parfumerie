<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('account/address')]
final class AddressController extends AbstractController
{
    #[Route(name: 'address.index', methods: ['GET'])]
    public function index(AddressRepository $addressRepository): Response
    {
        // Filtrer les adresses par utilisateur connecté
        return $this->render('address/index.html.twig', [
            'addresses' => $addressRepository->findBy(['user' => $this->getUser()]),
        ]);
    }

    #[Route('/new', name: 'address.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            $entityManager->persist($address);
            $entityManager->flush();

            $this->addFlash('success', 'Address successfully created.');

            if ($session->get('order') === 1) {
                $session->set('order', 0);
                return $this->redirectToRoute('order');
            }
            return $this->redirectToRoute('address.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('address/new.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'address.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Address $address, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'utilisateur est le propriétaire de l'adresse
        if ($address->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('address.index'); // Rediriger si l'utilisateur n'est pas propriétaire
        }

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Address successfully updated.');
            return $this->redirectToRoute('address.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('address/edit.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'address.show', methods: ['GET'])]
    public function show(Address $address): Response
    {
        // Vérifier que l'utilisateur est le propriétaire de l'adresse
        if ($address->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('address.index'); // Rediriger si l'utilisateur n'est pas propriétaire
        }

        return $this->render('address/show.html.twig', [
            'address' => $address,
        ]);
    }

    #[Route('/{id}', name: 'address.delete', methods: ['POST'])]
    public function delete(Request $request, Address $address, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que l'utilisateur est le propriétaire de l'adresse
        if ($address->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('address.index'); // Rediriger si l'utilisateur n'est pas propriétaire
        }

        if ($this->isCsrfTokenValid('delete' . $address->getId(), $request->request->get('_token'))) {
            $entityManager->remove($address);
            $entityManager->flush();
            $this->addFlash('success', 'Address successfully deleted.');
        }

        return $this->redirectToRoute('address.index', [], Response::HTTP_SEE_OTHER);
    }
}

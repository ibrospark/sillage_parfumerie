<?php

namespace App\Controller;

use App\Entity\Page;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/page')]
final class PageController extends AbstractController
{
    #[Route('/', name: 'page.index', methods: ['GET'])]
    public function index(PageRepository $pageRepository): Response
    {
        // Récupération de toutes les pages
        $pages = $pageRepository->findAll();

        // Rendu de la liste des pages
        return $this->render('page/index.html.twig', [
            'pages' => $pages,
        ]);
    }

    #[Route('/{slug}', name: 'page.show', methods: ['GET'])]
    public function show(PageRepository $pageRepository, string $slug): Response
    {
        // Recherche de la page par slug
        $page = $pageRepository->findOneBySlug($slug);

        // Si la page n'existe pas, renvoyer une erreur 404
        if (!$page) {
            throw $this->createNotFoundException('La page n\'existe pas.');
        }

        // Rendu de la page avec ses données
        return $this->render('page/show.html.twig', [
            'page' => $page,
        ]);
    }
}

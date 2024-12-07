<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/blog')]
final class BlogController extends AbstractController
{
    #[Route(name: 'blog.index', methods: ['GET'])]
    public function index(
        Request $request,
        BlogRepository $blogRepository,
        PaginatorInterface $paginator
    ): Response {
        // Pagination des blogs
        $pagination = $paginator->paginate(
            $blogRepository->createQueryBuilder('b'),
            $request->query->getInt('page', 1),
            10 // Nombre d'articles par page
        );

        return $this->render('blog/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/{id}', name: 'blog.show', methods: ['GET'])]
    public function show(Blog $blog): Response
    {
        return $this->render('blog/show.html.twig', [
            'blog' => $blog,
            'authors' => $blog->getAuthor(), // Récupération des auteurs du blog
        ]);
    }
}

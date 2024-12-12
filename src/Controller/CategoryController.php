<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository; // Ajoutez cet import
use Knp\Component\Pager\PaginatorInterface; // Assurez-vous que vous avez également importé PaginatorInterface si utilisé


#[Route('/category')]
final class CategoryController extends AbstractController
{
    #[Route(name: 'category.index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }
    #[Route('/{id}', name: 'category.show', methods: ['GET'])]
    public function show(Category $category, ProductRepository $productRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Get the current page number from the request (default is 1)
        $page = $request->query->getInt('page', 1);
        $limit = 24; // Number of items per page
    
        // Create a query builder for products by category
        $queryBuilder = $productRepository->createQueryBuilder('p')
            ->where('p.category = :category')
            ->setParameter('category', $category);
    
        // Fetch paginated results
        $pagination = $paginator->paginate(
            $queryBuilder, // QueryBuilder
            $page, // Current page number
            $limit // Number of items per page
        );
    
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'pagination' => $pagination, // Pass paginated products
            'title_page' => 'Nos marques de parfums',
        ]);
    }
    
}

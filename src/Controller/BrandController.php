<?php

namespace App\Controller;



use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Brand;
use App\Form\BrandType;
use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/brand')]
final class BrandController extends AbstractController
{
    #[Route(name: 'brand.index', methods: ['GET'])]
    public function index(BrandRepository $brandRepository): Response
    {
        return $this->render('brand/index.html.twig', [
            'brands' => $brandRepository->findAll(),
            'title_page' => 'Nos marques',

        ]);
    }
    #[Route('/{id}', name: 'brand.show', methods: ['GET'])]
    public function show(Brand $brand, ProductRepository $productRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Get the current page number from the request (default is 1)
        $page = $request->query->getInt('page', 1);
        $limit = 24; // Number of items per page

        // Create a query builder for products by brand
        $queryBuilder = $productRepository->createQueryBuilder('p')
            ->where('p.brand = :brand')
            ->setParameter('brand', $brand);

        // Fetch paginated results
        $pagination = $paginator->paginate(
            $queryBuilder, // QueryBuilder
            $page, // Current page number
            $limit // Number of items per page
        );

        return $this->render('brand/show.html.twig', [
            'brand' => $brand,
            'pagination' => $pagination, // Pass paginated products
            'title_page' => 'Nos marques de parfums',
        ]);
    }

}

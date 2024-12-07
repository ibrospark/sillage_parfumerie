<?php

namespace App\Controller;

use App\Model\Search;
use App\Entity\Product;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use App\Repository\OlfactoryFamilyRepository;
use App\Repository\BrandRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/product')]
final class ProductController extends AbstractController
{
    #[Route(name: 'product.index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        ProductRepository $productRepository,
        OlfactoryFamilyRepository $olfactoryFamilyRepository,
        BrandRepository $brandRepository,
        PaginatorInterface $paginator
    ): Response {
        // Fetch all olfactory families and brands
        $olfactoryFamilies = $olfactoryFamilyRepository->findAll();
        $brands = $brandRepository->findAll();
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search, [
            'categories' => [], // Populate with available categories if needed
            'olfactory_notes' => [], // Populate with available olfactory notes if needed
            'olfactory_families' => $olfactoryFamilies,
            'brands' => $brands,
        ]);

        $form->handleRequest($request);

        // Using a ternary operator for pagination
        $pagination = $form->isSubmitted() && $form->isValid()
            ? $paginator->paginate(
                $productRepository->findWithSearch($search),
                $request->query->getInt('page', 1),
                26
            )
            : $paginator->paginate(
                $productRepository->createQueryBuilder('p'),
                $request->query->getInt('page', 1),
                26
            );

        return $this->render('product/index.html.twig', [
            'pagination' => $pagination,
            'olfactoryFamilies' => $olfactoryFamilies,
            'form' => $form->createView(),
            'brands' => $brands,
        ]);
    }

    #[Route('/{id}', name: 'product.show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'brand' => $product->getBrand(), // Directly access the brand
        ]);
    }
    #[Route('/product/search', name: 'search.show', methods: ['GET'])]
    public function search(
        Request $request,
        ProductRepository $productRepository,
        PaginatorInterface $paginator
    ): Response {
        // Récupérer le terme de recherche
        $searchTerm = $request->query->get('s', '');

        // Récupérer les résultats de la recherche
        $pagination = $paginator->paginate(
            $productRepository->createQueryBuilder('p')
                ->where('p.name LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%'),
            $request->query->getInt('page', 1),
            26
        );

        // Retourner la vue de résultats de recherche
        return $this->render('product/search.html.twig', [
            'pagination' => $pagination,
            'searchTerm' => $searchTerm,
        ]);
    }
}

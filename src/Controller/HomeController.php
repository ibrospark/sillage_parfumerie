<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\SliderRepository;
use App\Repository\HeadersRepository;
use App\Repository\ProductRepository;
use App\Repository\OlfactoryFamilyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home.index')]
    public function index(ProductRepository $productRepository, SliderRepository $sliderRepository, BrandRepository $brandsRepository): Response
    {

        // Exemple de tableau de types de visibilité
        $visibilityTypes = ['is_in_home'];

        // Récupération des produits correspondants
        $products = $productRepository->findByVisibilityTypes($visibilityTypes);
        $brands = $brandsRepository->findAll();
        $slides = $sliderRepository->findAll();

        // Mélanger les marques de manière aléatoire
        shuffle($brands);

        // Limiter à 10 marques
        $brands = array_slice($brands, 0, 10);

        return $this->render('home/index.html.twig', [
            'title_page' => 'Accueil - Sillage parfumerie',
            'featured_products' => $products,
            'slides' => $slides,
            'brands' => $brands
        ]);
    }

    #[Route('/exclusive', name: 'exclusive.index')]
    public function exclusive(BrandRepository $brandsRepository): Response
    {
        $visibilityTypes = ['Exclusivité'];  // Par exemple, vous pouvez remplacer par des types de visibilité dynamiques

        // Utilisez la variable correcte ($brandsRepository)
        $brands = $brandsRepository->findByVisibilityTypes($visibilityTypes);

        // Mélanger les marques de manière aléatoire
        shuffle($brands);

        return $this->render('brand/exclusive.html.twig', [
            'brands' => $brands,
        ]);
    }

    #[Route('/box-sillage', name: 'box_sillage.index', methods: ['GET', 'POST'])]
    public function box_sillage(
        Request $request,
        ProductRepository $productRepository,
        OlfactoryFamilyRepository $olfactoryFamilyRepository,
        BrandRepository $brandRepository,
        PaginatorInterface $paginator
    ): Response {
        // Exemple de tableau de types de visibilité
        $visibilityTypes = ['Box Sillage'];

        // Récupération des produits correspondants
        $products = $productRepository->findByVisibilityTypes($visibilityTypes);

        // Récupération des familles olfactives et des marques
        $olfactoryFamilies = $olfactoryFamilyRepository->findAll();
        $brands = $brandRepository->findAll();

        // Pagination des produits sans filtre
        $pagination = $paginator->paginate(
            $productRepository->createQueryBuilder('p')
                ->where('p.id IN (:productIds)')
                ->setParameter('productIds', array_map(fn($product) => $product->getId(), $products)),
            $request->query->getInt('page', 1),
            26
        );

        return $this->render('product/box_sillage.html.twig', [
            'pagination' => $pagination,
            'olfactoryFamilies' => $olfactoryFamilies,
            'brands' => $brands,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\SliderRepository;
use App\Repository\HeadersRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
}

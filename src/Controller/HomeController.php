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
        $featured_products = $productRepository->findFeaturedProducts();
        $brands = $brandsRepository->findAll();
        $slides = $sliderRepository->findAll();

        // Mélanger les marques de manière aléatoire
        shuffle($brands);

        // Limiter à 10 marques
        $brands = array_slice($brands, 0, 10);

        return $this->render('home/index.html.twig', [
            'title_page' => 'Accueil - Sillage parfumerie',
            'featured_products' => $featured_products,
            'slides' => $slides,
            'brands' => $brands
        ]);
    }
}

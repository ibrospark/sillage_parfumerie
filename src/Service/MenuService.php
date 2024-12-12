<?php
// src/Service/MenuService.php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Page;
use App\Entity\Category;
use App\Entity\Brand;

class MenuService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getMenuItems(bool $includePages = true, bool $includeCategories = true, bool $includeBrands = true): array
    {
        $menuItems = [];

        // Inclure les pages si nécessaire
        if ($includePages) {
            $pages = $this->entityManager->getRepository(Page::class)
                ->findBy(['is_in_menu' => true]);  // Filtre les pages qui sont dans le menu
            $menuItems['pages'] = $pages;
        }

        // Inclure les catégories si nécessaire
        if ($includeCategories) {
            $categories = $this->entityManager->getRepository(Category::class)
                ->findBy(['is_in_menu' => true]);  // Filtre les catégories qui sont dans le menu
            $menuItems['categories'] = $categories;
        }

        // Inclure les marques si nécessaire
        if ($includeBrands) {
            $brands = $this->entityManager->getRepository(Brand::class)
                ->findBy(['is_in_menu' => true]);  // Filtre les marques qui sont dans le menu
            $menuItems['brands'] = $brands;
        }

        return $menuItems;
    }
}

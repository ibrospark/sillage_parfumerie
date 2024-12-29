<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Brand;
use App\Entity\Order;
use App\Entity\Slider;
use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\Page;
use App\Entity\Category;
use App\Entity\OlfactoryFamily;
use App\Controller\Admin\BrandCrudController;
use App\Entity\Blog;
use App\Entity\ProductVariation;

use App\Entity\OlfactoryNote;
use App\Entity\PaymentMethod;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;


class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    #[IsGranted("ROLE_ADMIN")]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<center><img src="img/icon3.jpg" class="rounded-5" loading="lazy" width="60%"></center>')
            ->setFaviconPath('img/icon3.jpg')
            ->setLocales([
                'fr' => '🇫🇷 Français',
            ]);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Gestion des produits');

        yield MenuItem::subMenu('<div class="spkdv_menu_icon">Produits</div>', 'fas fa-box')
            ->setSubItems([
                MenuItem::linkToCrud('<div class="spkdv_menu_icon">Produits</div>', 'fas fa-box', Product::class),
                MenuItem::linkToCrud('<div class="spkdv_menu_icon">Variations</div>', 'fas fa-box', ProductVariation::class),
            ]);

        yield MenuItem::subMenu('<div class="spkdv_menu_icon">Taxonomies</div>', 'fas fa-tags')
            ->setSubItems([
                MenuItem::linkToCrud('<div class="spkdv_menu_icon">Catégories</div>', 'fas fa-folder', Category::class),
                MenuItem::linkToCrud('<div class="spkdv_menu_icon">Familles olfactives</div>', 'fas fa-leaf', OlfactoryFamily::class),
                MenuItem::linkToCrud('<div class="spkdv_menu_icon">Notes olfactives</div>', 'fas fa-flask', OlfactoryNote::class),
                MenuItem::linkToCrud('<div class="spkdv_menu_icon">Marques</div>', 'fas fa-flag', Brand::class),
            ]);

        yield MenuItem::section('Gestion des contenus');
        yield MenuItem::linkToCrud('<div class="spkdv_menu_icon">Blog</div>', 'fas fa-pen-nib', Blog::class);
        yield MenuItem::linkToCrud('<div class="spkdv_menu_icon">Pages</div>', 'fas fa-file-alt', Page::class);
        yield MenuItem::linkToCrud('<div class="spkdv_menu_icon">Sliders</div>', 'fas fa-images', Slider::class);


        yield MenuItem::section('Gestion des commandes');
        yield MenuItem::linkToCrud('<div class="spkdv_menu_icon">Commandes</div>', 'fas fa-shopping-cart', Order::class);


        yield MenuItem::section('Gestion des utilisateurs');
        yield MenuItem::linkToCrud('<div class="spkdv_menu_icon">Utilisateurs</div>', 'fas fa-users', User::class);


        yield MenuItem::section('Autres');
        yield MenuItem::linkToCrud('<div class="spkdv_menu_icon">Adresses</div>', 'fas fa-map-marker-alt', Address::class);
        yield MenuItem::linkToCrud('<div class="spkdv_menu_icon">Transporteurs</div>', 'fas fa-truck', Carrier::class);
        yield MenuItem::linkToCrud('<div class="spkdv_menu_icon">Moyens de paiement</div>', 'fas fa-credit-card', PaymentMethod::class);


        yield MenuItem::section('Navigation');
        yield MenuItem::linkToUrl('Retourner sur le site', 'fas fa-arrow-left', '/');
        yield MenuItem::linkToLogout('Déconnexion', 'fas fa-power-off');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('css/admin.css');
    }
}

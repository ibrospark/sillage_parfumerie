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
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;


class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    #[IsGranted("ROLE_ADMIN")]
    public function index(): Response
    {
        // return parent::index();
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sillage Parfumerie');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');

        // yield MenuItem::section('Produits');
        yield MenuItem::subMenu('Gestion des produits', 'fas fa-box')->setSubItems([
            MenuItem::linkToCrud('Produits', 'fas fa-box', Product::class),
            MenuItem::linkToCrud('Variations', 'fas fa-box', ProductVariation::class),
        ]);;

        yield MenuItem::subMenu('Taxonomies', 'fas fa-tags')->setSubItems([
            MenuItem::linkToCrud('Catégories', 'fas fa-folder', Category::class),
            MenuItem::linkToCrud('Familles olfactives', 'fas fa-leaf', OlfactoryFamily::class),
            MenuItem::linkToCrud('Notes olfactives', 'fa fa-flask', OlfactoryNote::class),
            MenuItem::linkToCrud('Marques', 'fas fa-flag', Brand::class),
        ]);
        yield MenuItem::linkToCrud('Adresses', 'fa fa-map-marker', Address::class);
        yield MenuItem::linkToCrud('Transporteurs', 'fas fa-truck', Carrier::class);
        yield MenuItem::linkToCrud('Moyens de Paiement', 'fas fa-credit-card', PaymentMethod::class);
        yield MenuItem::linkToCrud('Commandes', 'fas fa-receipt', Order::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Blog', 'fas fa-book-open', Blog::class);
        yield MenuItem::linkToCrud('Page', 'fas fa-file', Page::class);
        yield MenuItem::linkToCrud('Sliders', 'fas fa-sliders-h', Slider::class);
    }
}

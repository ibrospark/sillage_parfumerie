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
            ->setTitle('<center><img src="img/icon2.png" class="rounded-5" height="100px">
                        </center>')
            ->setFaviconPath('img/icon1.png');
    }

    public function configureMenuItems(): iterable
    {
        // #64748b
        yield MenuItem::subMenu(
            '<div class="d-flex justify-content-start">
                <div>
                    <object class="icon_menu" type="image/svg+xml" data="img/menu/products.svg" height="20px"></object>
                </div>
                <div class="mx-1">
                     Produits
                </div>
            </div>'
        )

            ->setSubItems([
                MenuItem::linkToCrud(
                    '<div class="d-flex justify-content-start">
                <div>
                    <object class="icon_menu" type="image/svg+xml" data="img/menu/perfume.svg" height="20px"></object>
                </div>
                <div class="mx-1">
                    Produits
                </div>
            </div>',
                    '',
                    Product::class
                ),
                MenuItem::linkToCrud(
                    '<div class="d-flex justify-content-start">
                <div>
                    <object class="icon_menu" type="image/svg+xml" data="img/menu/variant.svg" height="20px"></object>
                </div>
                <div class="mx-1">
                    Variations de produits  
                </div>
            </div>',
                    '',
                    ProductVariation::class
                ),
            ]);

        yield MenuItem::subMenu(
            '<div class="d-flex justify-content-start">
                <div>
                    <object class="icon_menu" type="image/svg+xml" data="img/menu/taxonomy2.svg" height="20px"></object>
                </div>
                <div class="mx-1">
                    Taxonomies
                </div>
            </div>',
            ''
        )->setSubItems([
            MenuItem::linkToCrud('Catégories', 'fas fa-folder', Category::class),
            MenuItem::linkToCrud('Familles olfactives', 'fas fa-leaf', OlfactoryFamily::class),
            MenuItem::linkToCrud('Notes olfactives', 'fas fa-leaf', OlfactoryNote::class),
            MenuItem::linkToCrud('Marques', 'fas fa-tags', Brand::class),
        ]);
        yield MenuItem::linkToCrud(
            '<div class="d-flex justify-content-start">
                <div>
                    <object class="icon_menu" type="image/svg+xml" data="img/menu/map.svg" height="20px"></object>
                </div>
                <div class="mx-1">
                    Adresses
                </div>
            </div>',
            '',
            Address::class
        );
        yield MenuItem::linkToCrud(
            '<div class="d-flex justify-content-start">
                <div>
                    <object class="icon_menu" type="image/svg+xml" data="img/menu/deliver.svg" height="20px"></object>
                </div>
                <div class="mx-1">
                    Transporteurs
                </div>
            </div>',
            '',
            Carrier::class
        );
        yield MenuItem::linkToCrud(
            '<div class="d-flex justify-content-start">
                <div>
                    <object class="icon_menu" type="image/svg+xml" data="img/menu/payment.svg" height="20px"></object>
                </div>
                <div class="mx-1">
                    Moyens de paiement
                </div>
            </div>',
            '',
            PaymentMethod::class
        );
        yield MenuItem::linkToCrud(
            '<div class="d-flex justify-content-start">
                <div>
                    <object class="icon_menu" type="image/svg+xml" data="img/menu/order.svg" height="20px"></object>
                </div>
                <div class="mx-1">
                    Commandes
                </div>
            </div>',
            '',
            Order::class
        );
        yield MenuItem::linkToCrud(
            '<div class="d-flex justify-content-start">
                <div>
                    <object class="icon_menu" type="image/svg+xml" data="img/menu/user.svg" height="20px"></object>
                </div>
                <div class="mx-1">
                    Utilisateurs
                </div>
            </div>',
            '',
            User::class
        );
        yield MenuItem::linkToCrud(
            '<div class="d-flex justify-content-start">
                <div>
                    <object class="icon_menu" type="image/svg+xml" data="img/menu/blog.svg" height="20px"></object>
                </div>
                <div class="mx-1">
                    Blog
                </div>
            </div>',
            '',
            Blog::class
        );
        yield MenuItem::linkToCrud(
            '<div class="d-flex justify-content-start">
                <div>
                    <object class="icon_menu" type="image/svg+xml" data="img/menu/page.svg" height="20px"></object>
                </div>
                <div class="mx-1">
                    Pages
                </div>
            </div>',
            '',
            Page::class
        );
        yield MenuItem::linkToCrud(
            '<div class="d-flex justify-content-start">
                <div>
                    <object class="icon_menu" type="image/svg+xml" data="img/menu/carousel.svg" height="20px"></object>
                </div>
                <div class="mx-1">
                    Sliders
                </div>
            </div>',
            '',
            Slider::class
        );
        yield MenuItem::linkToUrl('Retourner sur le site', 'fas fa-arrow-left', '/');
        yield MenuItem::linkToLogout('Déconnexion', 'fa fa-power-off');
    }
    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('css/admin.css');
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\ProductVariation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class ProductVariationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductVariation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('product', "Nom du produit principal"),
            // REGULAR PRICE
            MoneyField::new('regular_price', 'Prix régulier')
                ->setFormTypeOption('empty_data', "0.0")
                ->setCurrency('XOF')
                ->setRequired(false),
            // SALE PRICE
            MoneyField::new('sale_price', 'Prix promotionnel')
                ->setFormTypeOption('empty_data', "0.0")
                ->setCurrency('XOF')
                ->setRequired(false),
            // STOCK QUANTITY
            IntegerField::new('stock_quantity', 'Qté.Stock')
                ->setFormTypeOption('empty_data', "0")
                ->setRequired(false),

            // CAPACITY
            TextField::new('capacity', 'Contenance')
                ->hideOnIndex()
                ->setFormTypeOption('empty_data', '')
                ->setRequired(false),

            // IMAGE
            ImageField::new('image_url', 'Image')
                ->setBasePath('img/products')
                ->setUploadDir('public/img/products')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(100)  // Définir 100 éléments par page
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des variations de produits')  // Titre de la page d'index
            ->setDefaultSort(['created_at' => 'DESC']) // Trier par 'created_at' de manière décroissante
            ->setSearchFields(['id', 'name', 'description', 'capacity', 'regular_price', 'sale_price', 'stock_quantity'])  // Champs de recherche
            ->setEntityLabelInSingular('Variation de produit')  // Label de l'entité en singulier
            ->setEntityLabelInPlural('Variations de produits');  // Label de l'entité en pluriel

    }
}
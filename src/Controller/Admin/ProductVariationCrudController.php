<?php

namespace App\Controller\Admin;

use App\Entity\ProductVariation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;






use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

class ProductVariationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductVariation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            FormField::addColumn('col-md-12'),
            FormField::addPanel('INFORMATIONS DE LA VARIATION')
                ->collapsible()
                ->setCssClass('row my-2'),
            // NAME OF ATTACHED PRODUCT
            AssociationField::new('product', "Nom du produit principal"),
            // IMAGE
            ImageField::new('image_url', 'Image')
                ->setBasePath('img/products')
                ->setUploadDir('public/img/products')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),



            // REGULAR PRICE
            MoneyField::new('regular_price', 'Prix régulier')
                ->setFormTypeOption('empty_data', "0.0")
                ->setCurrency('XOF')
                ->setRequired(false)
                ->setColumns('col-6 p-1'),
            // SALE PRICE
            MoneyField::new('sale_price', 'Prix promotionnel')
                ->setFormTypeOption('empty_data', "0.0")
                ->setCurrency('XOF')
                ->setRequired(false)->setColumns('col-6 p-1'),


            // CAPACITY
            ChoiceField::new('capacity', 'Contenance')
                ->setChoices([
                    'Try me' => 'Try me',
                    '10 ml' => '10 ml',
                    '15 ml' => '15 ml',
                    '25 ml' => '25 ml',
                    '30 ml' => '30 ml',
                    '50 ml' => '50 ml',
                    '60 ml' => '60 ml',
                    '75 ml' => '75 ml',
                    '90 ml' => '90 ml',
                    '100 ml' => '100 ml',
                    '125 ml' => '125 ml',
                    '150 ml' => '150 ml',
                    '200 ml' => '200 ml',
                    '250 ml' => '250 ml',
                    '300 ml' => '300 ml',
                    '350 ml' => '350 ml',
                    '400 ml' => '400 ml',
                    '450 ml' => '450 ml',
                    '500 ml' => '500 ml',
                    '550 ml' => '550 ml',
                    '600 ml' => '600 ml',
                    '650 ml' => '650 ml',
                    '700 ml' => '700 ml',
                    '750 ml' => '750 ml',
                    '800 ml' => '800 ml',
                    '850 ml' => '850 ml',
                    '900 ml' => '900 ml',
                    '950 ml' => '950 ml',
                    '1000 ml' => '1000 ml',
                    'Autre' => 'Autre',
                ])
                ->hideOnIndex()
                ->setFormTypeOption('empty_data', ['Autre'])
                ->setRequired(false)
                ->setColumns('col-md-4 p-1'),




            // STOCK QUANTITY
            IntegerField::new('stock_quantity', 'Qté.Stock')
                ->setFormTypeOption('empty_data', "0")
                ->setRequired(false)
                ->setColumns('col-md-4 p-1'),


        ];
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('product', 'Nom du produit principal'))
            ->add(NumericFilter::new('regular_price', 'Prix régulier'))
            ->add(NumericFilter::new('sale_price', 'Prix promotionnel'))
            ->add(TextFilter::new('capacity', 'Contenance'))
            ->add(NumericFilter::new('stock_quantity', 'Qté.Stock'));
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(100)  // Définir 100 éléments par page
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des variations de parfums')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter une variation de parfum')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier une variation de parfum')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails de la variation de parfum')
            ->setEntityLabelInSingular('variation de Parfum')
            ->setEntityLabelInPlural('variations de Parfums');
    }
}

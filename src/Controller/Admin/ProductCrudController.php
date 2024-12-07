<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Désignation'),
            TextEditorField::new('description', 'Description')->hideOnIndex(),
            MoneyField::new('regular_price', 'Prix Régulier')->setCurrency('XOF'),
            MoneyField::new('sale_price', 'Prix de Vente')->setCurrency('XOF'),
            IntegerField::new('stock_quantity', 'Quantité en Stock')->hideOnIndex(),
            ImageField::new('image_url', 'Image')
                ->setBasePath('img/products')
                ->setUploadDir('public/img/products')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            TextField::new('capacity', 'Capacité')->hideOnIndex(),
            TextField::new('weight', 'Poids')->hideOnIndex(),
            AssociationField::new('brand', 'Marque'),
            AssociationField::new('category', 'Catégorie'),
            DateTimeField::new('created_at', 'Créé le')->setFormat('dd-MM-yyyy HH:mm')->hideOnForm(),
            DateTimeField::new('updated_at', 'Mis à jour le')->setFormat('dd-MM-yyyy HH:mm')->hideOnForm(),
            BooleanField::new('featured', 'Produit en Vedette')->setHelp('Afficher ce produit comme vedette')->hideOnIndex(),
            BooleanField::new('is_in_home', 'Produit en Page d\'Accueil')->setHelp('Afficher ce produit sur la page d\'accueil')->hideOnIndex(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits');
    }
}

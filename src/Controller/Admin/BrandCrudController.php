<?php

namespace App\Controller\Admin;

use App\Entity\Brand;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;  // Importation de CheckboxListField
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;  // Importation de CheckboxListField
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;


class BrandCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Brand::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom de la marque'),
            SlugField::new('slug')->setTargetFieldName('name'),
            TextEditorField::new('description', 'Description')
                ->setFormTypeOption('empty_data', '')
                ->setRequired(false)
                ->hideOnIndex(),
            TextEditorField::new('excerpt', 'Extrait')
                ->setFormTypeOption('empty_data', '')
                ->setRequired(false)
                ->hideOnIndex(),
            ImageField::new('cover_url', 'URL de la Couverture')
                ->setBasePath('img/brands/')
                ->setUploadDir('public/img/brands/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            ImageField::new('logo_url', 'URL du Logo')
                ->setBasePath('img/brands/')
                ->setUploadDir('public/img/brands/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            AssociationField::new('products', 'Produits')->hideOnForm(), // Assuming 'products' is the correct relation name
            ChoiceField::new('visibilityTypes', 'Visibilité')
                ->setChoices([
                    'Aucun' => 'Aucun',
                    'Dans la page d\'accueil' => 'is_in_home',
                    'Dans la menu de navigation' => 'is_in_menu',
                    'Exclusivité' => 'Exclusivité',
                    'Promotion' => 'Promotion',
                    'Édition limitée' => 'Édition limitée',
                    'Nouveauté' => 'Nouveauté',
                    'Sélection du mois' => 'month_selection',
                    'Best-seller' => 'best_seller',
                    'En vedette' => 'featured',
                ])
                ->setHelp('Sélectionnez les types de visibilité pour ce produit.')
                ->allowMultipleChoices()
                ->autocomplete(),

        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(100)  // Définir 100 éléments par page
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des marques')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter une marque')
            ->setPageTitle(Crud::PAGE_EDIT, "Modifier la marque")
            ->setPageTitle(Crud::PAGE_DETAIL, "Détails de la marque")
            ->setEntityLabelInSingular('Marque')
            ->setEntityLabelInPlural('Marques');
    }
}

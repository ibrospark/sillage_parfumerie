<?php

// src/Controller/Admin/PageCrudController.php
namespace App\Controller\Admin;

use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;  // Importation de CheckboxListField
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            SlugField::new('slug')->setTargetFieldName('title'),
            TextEditorField::new('content'),
            ImageField::new('image_url', 'Image')
                ->setBasePath('img/pages')
                ->setUploadDir('public/img/pages')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(true),
            DateTimeField::new('createdAt')->hideOnForm(),
            DateTimeField::new('updatedAt')->hideOnForm(),
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
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des pages')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter une page')
            ->setPageTitle(Crud::PAGE_EDIT, "Modifier la page")
            ->setPageTitle(Crud::PAGE_DETAIL, "Détails de la page")
            ->setEntityLabelInSingular('Page')
            ->setEntityLabelInPlural('Pages');
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\OlfactoryNote;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OlfactoryNoteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OlfactoryNote::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Désignation'),
            TextEditorField::new('description', 'Description')
                ->hideOnIndex()
                ->setFormTypeOption('empty_data', '')
                ->setRequired(false),
            ImageField::new('imageUrl', 'URL de l\'Image')
                ->setBasePath('img/olfactory_notes/')
                ->setUploadDir('public/img/olfactory_notes/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            // AssociationField::new('products_head_note', 'Produits (Tête)')->hideOnForm(), // Adjust relationship names as needed
            // AssociationField::new('products_heart_note', 'Produits (Cœur)')->hideOnForm(),
            // AssociationField::new('products_background_note', 'Produits (Fond)')->hideOnForm(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(100)  // Définir 100 éléments par page
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des notes olfactives')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter une note olfactive')
            ->setPageTitle(Crud::PAGE_EDIT, "Modifier la note olfactive")
            ->setPageTitle(Crud::PAGE_DETAIL, "Détails de la note olfactive")
            ->setEntityLabelInSingular('Note olfactive')
            ->setEntityLabelInPlural('Notes olfactives');
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Blog;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BlogCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Blog::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre'),
            SlugField::new('slug')->setTargetFieldName('title'),
            TextEditorField::new('content', 'Contenu')
                ->hideOnIndex()
                ->setFormTypeOption('empty_data', '')
                ->setRequired(false),
            ImageField::new('image_url', 'URL de l\'Image')
                ->setBasePath('img/blog/')
                ->setUploadDir('public/img/blog/')
                ->setUploadedFileNamePattern('[randomhash].[day].[month].[year].[extension]')
                ->setRequired(false),
            // AssociationField::new('author', 'Auteurs')
            //     ->setFormTypeOption('multiple', true)
            //     ->setFormTypeOption('expanded', true), // Affiche les auteurs sous forme de cases à cocher
            DateTimeField::new('created_at', 'Date de Création')->hideOnForm(),
            DateTimeField::new('updated_at', 'Date de Mise à Jour')->hideOnForm(),
            // STATUS
            ChoiceField::new('status', 'Statut')
                ->setChoices([
                    'Inactif' => '0',
                    'Actif' => '1',
                    'Brouillon' => '2',
                ])
                ->setHelp('Sélectionnez le statut.')
                ->autocomplete()
                ->setFormTypeOption('empty_data', ['0'])
                ->setRequired(false)
                ->hideOnIndex(),
        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(100)  // Définir 100 éléments par page
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des articles')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un article')
            ->setPageTitle(Crud::PAGE_EDIT, "Modifier l'article")
            ->setPageTitle(Crud::PAGE_DETAIL, "Détails de l'article")
            ->setEntityLabelInSingular('Article')
            ->setEntityLabelInPlural('Articless')
            ->setDefaultSort(['created_at' => 'DESC']);;
    }
}

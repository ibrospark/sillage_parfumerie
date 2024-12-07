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
            TextEditorField::new('content', 'Contenu')->hideOnIndex(),
            ImageField::new('image_url', 'URL de l\'Image')
                ->setBasePath('img/blog/')
                ->setUploadDir('public/img/blog/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            AssociationField::new('author', 'Auteurs')
                ->setFormTypeOption('multiple', true)
                ->setFormTypeOption('expanded', true), // Affiche les auteurs sous forme de cases à cocher
            DateTimeField::new('created_at', 'Date de Création')->hideOnForm(),
            DateTimeField::new('updated_at', 'Date de Mise à Jour')->hideOnForm(),
            ChoiceField::new('status', 'Statut')
                ->setChoices([
                    'Brouillon' => 0,
                    'Publié' => 1,
                    'Archivé' => 2,
                ]),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Article')
            ->setEntityLabelInPlural('Articles')
            ->setDefaultSort(['created_at' => 'DESC']);
    }
}

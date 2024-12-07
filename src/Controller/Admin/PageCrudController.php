<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // Masquer l'ID lors de la création ou modification
            TextField::new('name', 'Nom de la page'),
            TextEditorField::new('content', 'Contenu'), // Utilisation de TextEditor pour du contenu riche
            TextField::new('slug', 'Slug'),
            BooleanField::new('is_published', 'Publié'),
            TextField::new('position', 'Position'),
            DateTimeField::new('created_at', 'Date de création')->onlyOnDetail(),
            DateTimeField::new('updated_at', 'Date de mise à jour')->onlyOnDetail(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Page')
            ->setEntityLabelInPlural('Pages')
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des Pages') // Titre de la page d'index
            ->setPageTitle(Crud::PAGE_NEW, 'Créer une nouvelle page') // Titre de la page de création
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier la page'); // Titre de la page d'édition
    }
}

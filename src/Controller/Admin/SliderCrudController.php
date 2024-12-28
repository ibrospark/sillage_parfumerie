<?php

namespace App\Controller\Admin;

use App\Entity\Slider;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SliderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Slider::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre'),
            TextEditorField::new('description', 'Description')->hideOnIndex(),
            TextField::new('video_url', 'URL de la Vidéo')
                ->setRequired(true) // Rendre ce champ requis si nécessaire
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(100)  // Définir 100 éléments par page
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des slides')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un slide')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un slide')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails du slide')
            ->setEntityLabelInSingular('Slide')
            ->setEntityLabelInPlural('Slides');
    }
}

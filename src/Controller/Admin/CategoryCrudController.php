<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;  // Importation de CheckboxListField
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;  // Importation de CheckboxListField
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;  // Importation de CheckboxListField
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;  // Importation de SlugField

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // Masque l'ID lors de la création/modification
            TextField::new('name', 'Nom de la catégorie'), // Champ pour le nom
            SlugField::new('slug')->setTargetFieldName('name'),
            ChoiceField::new('visibilityTypes', 'Visibilité') // Champ pour la visibilité
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
            ImageField::new('image_url', 'Image')
                ->setBasePath('img/categories')
                ->setUploadDir('public/img/categories')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),


        ];
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(100)  // Définir 100 éléments par page
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des categories')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter une categorie')
            ->setPageTitle(Crud::PAGE_EDIT, "Modifier la categorie")
            ->setPageTitle(Crud::PAGE_DETAIL, "Détails de la categorie")
            ->setEntityLabelInSingular('Categorie')
            ->setEntityLabelInPlural('Categories');
    }
}

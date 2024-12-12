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
            TextEditorField::new('description', 'Description'), // Champ pour la description
            ChoiceField::new('visibilityTypes')
            ->setChoices([
                'Exclusivité' => 'Exclusivité',
                'En vedette' => 'En vedette',
                'Promotion' => 'Promotion',
                'Édition limitée' => 'Édition limitée',
                'Aucun' => 'Aucun',
                'Nouveauté' => 'Nouveauté',
                'Baisse de prix' => 'Baisse de prix',
                'Sélection du mois' => 'Sélection du mois',
                'Best-seller' => 'Best-seller'
            ])
            ->setHelp('Sélectionnez les types de visibilité pour ce produit.')
            ->allowMultipleChoices()
            ->autocomplete(),
            ImageField::new('image_url', 'Image')
            ->setBasePath('img/categories')
            ->setUploadDir('public/img/categories')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            BooleanField::new('is_in_menu')->setLabel('Afficher dans le menu') // Ajout du champ isInMenu

   
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Catégorie') // Label au singulier
            ->setEntityLabelInPlural('Catégories') // Label au pluriel
            ->setSearchFields(['name', 'description']); // Permet la recherche par nom et description
    }
}

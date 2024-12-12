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
            TextField::new('name', 'Désignation'),
            TextEditorField::new('description', 'Description')->hideOnIndex(),
            TextEditorField::new('excerpt', 'Extrait')->hideOnIndex(),
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
            BooleanField::new('is_in_menu')->setLabel('Afficher dans le menu') // Ajout du champ isInMenu

   
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Marque')
            ->setEntityLabelInPlural('Marques');
    }
}

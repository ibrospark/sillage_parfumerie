<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn('col-md-12'),
            FormField::addPanel('INFORMATIONS DE BASE')
                ->collapsible()
                ->setCssClass('row my-2'),
            // ID 
            IntegerField::new('id')->onlyOnIndex(),

            // NAME
            TextField::new('name', 'Nom du produit')
                ->setColumns('col-md-6 p-1'),


            SlugField::new('slug')
                ->setTargetFieldName('name')
                ->setColumns('col-md-6 p-1')
                ->hideOnIndex(true), // Ajoute 'col-md-4' pour occuper 4 colonnes

            // SHORT DESCRIPTION
            // DESCRIPTION
            TextEditorField::new('description', 'Description')
                ->hideOnIndex()
                ->setFormTypeOption('empty_data', '')
                ->setRequired(false),
            // IMAGE
            ImageField::new('image_url', 'Image')
                ->setBasePath('img/products')
                ->setUploadDir('public/img/products')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),






            // REGULAR PRICE
            MoneyField::new('regular_price', 'Prix régulier')
                ->setFormTypeOption('empty_data', "0.0")
                ->setCurrency('XOF')
                ->setRequired(false)
                ->setColumns('col-6 p-1'),
            // SALE PRICE
            MoneyField::new('sale_price', 'Prix promotionnel')
                ->setFormTypeOption('empty_data', "0.0")
                ->setCurrency('XOF')
                ->setRequired(false)->setColumns('col-6 p-1'),


            // CAPACITY
            ChoiceField::new('capacity', 'Contenance')
                ->setChoices([
                    'Try me' => 'Try me',
                    '10 ml' => '10 ml',
                    '15 ml' => '15 ml',
                    '25 ml' => '25 ml',
                    '30 ml' => '30 ml',
                    '50 ml' => '50 ml',
                    '60 ml' => '60 ml',
                    '75 ml' => '75 ml',
                    '90 ml' => '90 ml',
                    '100 ml' => '100 ml',
                    '125 ml' => '125 ml',
                    '150 ml' => '150 ml',
                    '200 ml' => '200 ml',
                    '250 ml' => '250 ml',
                    '300 ml' => '300 ml',
                    '350 ml' => '350 ml',
                    '400 ml' => '400 ml',
                    '450 ml' => '450 ml',
                    '500 ml' => '500 ml',
                    '550 ml' => '550 ml',
                    '600 ml' => '600 ml',
                    '650 ml' => '650 ml',
                    '700 ml' => '700 ml',
                    '750 ml' => '750 ml',
                    '800 ml' => '800 ml',
                    '850 ml' => '850 ml',
                    '900 ml' => '900 ml',
                    '950 ml' => '950 ml',
                    '1000 ml' => '1000 ml',
                    'Autre' => 'Autre',
                ])
                ->hideOnIndex()
                ->setFormTypeOption('empty_data', ['Autre'])
                ->setRequired(false)
                ->setColumns('col-md-4 p-1'),


            // STOCK QUANTITY
            IntegerField::new('stock_quantity', 'Qté.Stock')
                ->setFormTypeOption('empty_data', "0")
                ->setRequired(false)
                ->setColumns('col-md-4 p-1'),
            // WEIGHT
            TextField::new('weight', 'Poids')
                ->hideOnIndex()
                ->setFormTypeOption('empty_data', '')
                ->setRequired(false)
                ->setRequired(false)
                ->setColumns('col-md-4 p-1'),

            // VARIATIONS SECTION -----------------------------------------------------------------------------------------------
            FormField::addFieldset('VARIATIONS')
                ->collapsible()
                ->setCssClass('row my-2'),
            AssociationField::new('productVariations') // Ajout de la gestion des variations
                ->setCrudController(ProductVariationCrudController::class) // Lien vers le CRUD de ProductVariation
                ->setFormTypeOption('by_reference', false) // Permet d'ajouter des variations sans quitter la page
                ->setFormTypeOption('required', false) // Le champ n'est pas obligatoire
                ->onlyOnForms(),



            // TAXONOMIES SECTION -----------------------------------------------------------------------------------------------
            FormField::addFieldset('TAXONOMIES')
                ->collapsible()
                ->setCssClass('row my-2'),
            AssociationField::new('brand', 'Marque')
                ->setColumns('col-md-4 p-1'),
            AssociationField::new('category', 'Catégorie')
                ->setColumns('col-md-4 p-1'),
            AssociationField::new('olfactoryFamily', 'Famille.olf')
                ->setColumns('col-md-4 p-1'),
            // NOTES OLFACTIVE SECTION -----------------------------------------------------------------------------------------------
            FormField::addFieldset('NOTES OLFACTIVES')
                ->collapsible()
                ->setCssClass('row my-2'),

            // OLFACTORIES NOTES
            AssociationField::new('head_note', 'Note de tête')
                ->hideOnIndex()
                ->setColumns('col-md-4 p-1'),
            AssociationField::new('heart_note', 'Note de cœur')
                ->hideOnIndex()
                ->setColumns('col-md-4 p-1'),
            AssociationField::new('background_note', 'Note de fond')
                ->hideOnIndex()
                ->setColumns('col-md-4 p-1'),
            // PROFIL OLFACTIF SECTION -----------------------------------------------------------------------------------------------
            FormField::addFieldset('PROFIL OLFACTIF')
                ->collapsible()
                ->setCssClass('row my-2'),

            // CONCENTRATION
            ChoiceField::new('concentration', 'Concentration')
                ->setChoices([
                    'Attar/Huile' => 'Attar/Huile',
                    'Eau de Cologne' => 'Eau de Cologne',
                    'Eau de Parfum' => 'Eau de Parfum',
                    'Eau de Toilette' => 'Eau de Toilette',
                    'Extrait de Parfum' => 'Extrait de Parfum',
                    'Parfum' => 'Parfum',
                    'Autre' => 'Autre',

                ])
                ->setHelp('Sélectionnez la concentration.')
                ->autocomplete()
                ->setFormTypeOption('empty_data', ['Autre'])
                ->hideOnIndex(true)
                ->setRequired(false)
                ->setColumns('col-md-4 p-1'),

            // SEASON
            ChoiceField::new('season', 'Saison')
                ->setChoices([
                    'Printemps' => 'Printemps',
                    'Été' => 'Été',
                    'Automne' => 'Automne',
                    'Hiver' => 'Hiver',
                    'Toutes saisons' => 'Toutes saisons',
                ])
                ->setHelp('Sélectionnez la saison.')
                ->autocomplete()
                ->hideOnIndex()
                ->setFormTypeOption('empty_data', ['Toutes saisons'])
                ->setRequired(false)
                ->setColumns('col-md-4 p-1'),


            // OCCASION
            ChoiceField::new('occasion', 'Occasion')
                ->setChoices([
                    'Toute occasion' => 'Toute occasion',
                    'Parfum de jour' => 'Parfum de jour',
                    'Parfum de soirée' => 'Parfum de soirée',
                    'Autre' => 'Autre',
                ])
                ->setHelp('Sélectionnez l\'occasion.')
                ->autocomplete()
                ->hideOnIndex()
                ->setFormTypeOption('empty_data', ['Autre'])
                ->setRequired(false)
                ->setColumns('col-md-4 p-1'),


            // INTENSITY
            ChoiceField::new('intensity', 'Intensité')
                ->setChoices([
                    'Discret' => 'Discret',
                    'Modéré' => 'Modéré',
                    'Puissant' => 'Puissant',
                    'Autre' => 'Autre',
                ])
                ->setHelp('Sélectionnez l\'intensité.')
                ->autocomplete()
                ->hideOnIndex()
                ->setFormTypeOption('empty_data', ['Autre'])
                ->setRequired(false)
                ->setColumns('col-md-4 p-1'),



            // GENDER
            ChoiceField::new('gender', 'Genre')
                ->setChoices([
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                    'Unisexe' => 'Unisexe',
                ])
                ->setHelp('Sélectionnez le genre.')
                ->autocomplete()
                ->hideOnIndex()
                ->setFormTypeOption('empty_data', ['Autre'])
                ->setRequired(false)
                ->setColumns('col-md-4 p-1'),

            // VISIBILITY SECTION -----------------------------------------------------------------------------------------------
            FormField::addFieldset('VISIBILITÉ')
                ->collapsible()
                ->setCssClass('row my-2'),

            // PRODUCT VISIBILITY
            ChoiceField::new('visibilityTypes', 'Visibilité')
                ->setChoices([
                    'Aucun' => 'Aucun',
                    'Dans la page d\'accueil' => 'is_in_home',
                    'Exclusivité' => 'Exclusivité',
                    'Promotion' => 'Promotion',
                    'Édition limitée' => 'Édition limitée',
                    'Nouveauté' => 'Nouveauté',
                    'Sélection du mois' => 'month_selection',
                    'Best-seller' => 'best_seller',
                    'Box Sillage' => 'Box Sillage',

                    'En vedette' => 'featured',
                ])
                ->setHelp('Sélectionnez les types de visibilité pour ce produit.')
                ->allowMultipleChoices()
                ->autocomplete()
                ->setColumns('col-md-6 p-1'),
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
                ->setColumns('col-md-6 p-1'),

            // CREATED AND UPDATED DATE
            DateTimeField::new('created_at', 'Créé le')->onlyOnIndex(),
            DateTimeField::new('updated_at', 'Mis à jour le')->onlyOnIndex(),
        ];
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('name', 'Nom du produit'))
            ->add(EntityFilter::new('brand', 'Marque'))
            ->add(EntityFilter::new('category', 'Catégorie'))
            ->add(EntityFilter::new('olfactoryFamily', 'Famille olfactive'))
            ->add(NumericFilter::new('regular_price', 'Prix régulier'))
            ->add(NumericFilter::new('sale_price', 'Prix promotionnel'))
            ->add(BooleanFilter::new('status', 'Statut'))
            ->add(DateTimeFilter::new('created_at', 'Créé le'))
            ->add(DateTimeFilter::new('updated_at', 'Mis à jour le'));
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(100)  // Définir 100 éléments par page
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des parfums')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un parfum')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un parfum')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails du parfum')
            ->setEntityLabelInSingular('Parfum')
            ->setEntityLabelInPlural('Parfums')
            ->setDateTimeFormat('dd/MM/yyyy HH:mm:ss')
            ->setDefaultSort(['created_at' => 'DESC']);  // Trier par 'created_at' de manière décroissante
    }
}

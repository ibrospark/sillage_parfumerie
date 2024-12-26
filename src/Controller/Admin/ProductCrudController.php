<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            // ID
            IntegerField::new('id')->onlyOnIndex(),
            // NAME
            TextField::new('name', 'Nom du produit'),

            SlugField::new('slug')
                ->setTargetFieldName('name'),
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
            // VARIATIONS
            AssociationField::new('productVariations') // Ajout de la gestion des variations
                ->setCrudController(ProductVariationCrudController::class) // Lien vers le CRUD de ProductVariation
                ->setFormTypeOption('by_reference', false) // Permet d'ajouter des variations sans quitter la page
                ->setFormTypeOption('required', false) // Le champ n'est pas obligatoire
                ->onlyOnForms(),

            // REGULAR PRICE
            MoneyField::new('regular_price', 'Prix régulier')
                ->setFormTypeOption('empty_data', "0.0")
                ->setCurrency('XOF')
                ->setRequired(false),
            // SALE PRICE
            MoneyField::new('sale_price', 'Prix promotionnel')
                ->setFormTypeOption('empty_data', "0.0")
                ->setCurrency('XOF')
                ->setRequired(false),
            // STOCK QUANTITY
            IntegerField::new('stock_quantity', 'Qté.Stock')
                ->setFormTypeOption('empty_data', "0")
                ->setRequired(false),

            // CAPACITY
            TextField::new('capacity', 'Contenance')
                ->hideOnIndex()
                ->setFormTypeOption('empty_data', '')
                ->setRequired(false),

            // WEIGHT
            TextField::new('weight', 'Poids')
                ->hideOnIndex()
                ->setFormTypeOption('empty_data', '')
                ->setRequired(false),



            // TAXONOMIES
            AssociationField::new('brand', 'Marque'),
            AssociationField::new('category', 'Catégorie'),
            AssociationField::new('olfactoryFamily', 'Famille.olf'),
            // OLFACTORIES NOTES
            AssociationField::new('head_note', 'Note de tête')
                ->hideOnIndex(),
            AssociationField::new('heart_note', 'Note de cœur')
                ->hideOnIndex(),
            AssociationField::new('background_note', 'Note de fond')
                ->hideOnIndex(),
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
                    'En vedette' => 'featured',
                ])
                ->setHelp('Sélectionnez les types de visibilité pour ce produit.')
                ->allowMultipleChoices()
                ->autocomplete(),
            // SEASON
            ChoiceField::new('season', 'Saison')
                ->setChoices([
                    'Printemps' => 'Printemps',
                    'Été' => 'Été',
                    'Automne' => 'Automne',
                    'Hiver' => 'Hiver',
                    'Autre' => 'Autre',
                ])
                ->setHelp('Sélectionnez la saison.')
                ->autocomplete()
                ->hideOnIndex()
                ->setFormTypeOption('empty_data', ['Autre'])
                ->setRequired(false),


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
                ->setRequired(false),


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
                ->setRequired(false),



            // GENDER
            ChoiceField::new('gender', 'Genre')
                ->setChoices([
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                    'Unisexe' => 'Unisexe',
                    'Autre' => 'Autre',
                ])
                ->setHelp('Sélectionnez le genre.')
                ->autocomplete()
                ->hideOnIndex()
                ->setFormTypeOption('empty_data', ['Autre'])
                ->setRequired(false),


            // STATUS
            ChoiceField::new('status', 'Statut')
                ->setChoices([
                    'Inactif' => '0',
                    'Actif' => '1',
                    'Brouillon' => '2',
                ])
                ->setHelp('Sélectionnez le statut.')
                ->autocomplete()
                ->setFormTypeOption('empty_data', ['0']),

            // CREATED AND UPDATED DATE
            DateTimeField::new('created_at', 'Créé le')->onlyOnIndex(),
            DateTimeField::new('updated_at', 'Mis à jour le')->onlyOnIndex(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(100)  // Définir 100 éléments par page
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des parfums')
            ->setDefaultSort(['created_at' => 'DESC']);  // Trier par 'created_at' de manière décroissante
    }
}

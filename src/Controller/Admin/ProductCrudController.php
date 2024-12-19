<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->onlyOnIndex(),
            TextField::new('name', 'Nom du produit'),
            TextareaField::new('description', 'Description')
                ->hideOnIndex(),
            MoneyField::new('regular_price', 'Prix régulier')
                ->setCurrency('XOF'),
            MoneyField::new('sale_price', 'Prix promotionnel')
                ->setCurrency('XOF'),
            IntegerField::new('stock_quantity', 'Quantité en stock'),
            TextField::new('capacity', 'Capacité'),
            TextField::new('weight', 'Poids'),
            ImageField::new('image_url', 'Image')
                ->setBasePath('img/products')
                ->setUploadDir('public/img/products')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            AssociationField::new('brand', 'Marque'),
            AssociationField::new('category', 'Catégorie'),
            AssociationField::new('olfactoryFamily', 'Famille olfactive'),

            AssociationField::new('head_note', 'Note de tête'),
            AssociationField::new('heart_note', 'Note de cœur'),
            AssociationField::new('background_note', 'Note de fond'),

            ChoiceField::new('visibilityTypes')
                ->setChoices([
                    'Exclusivité' => 'Exclusivité',
                    'Promotion' => 'Promotion',
                    'Édition limitée' => 'Édition limitée',
                    'Aucun' => 'Aucun',
                    'Nouveauté' => 'Nouveauté',
                    'Baisse de prix' => 'Baisse de prix',
                    'Sélection du mois' => 'month_selection',
                    'Best-seller' => 'best_seller',
                    'En vedette' => 'featured',
                    'Dans la page d\'accueil' => 'is_in_home'
                ])
                ->setHelp('Sélectionnez les types de visibilité pour ce produit.')
                ->allowMultipleChoices()
                ->autocomplete(),


            ChoiceField::new('season', 'Saison')
                ->setChoices([
                    'Printemps' => 'Printemps',
                    'Été' => 'Été',
                    'Automne' => 'Automne',
                    'Hiver' => 'Hiver',
                ])
                ->setHelp('Sélectionnez la saison.')
                ->autocomplete(),
            ChoiceField::new('occasion', 'Occasion')
                ->setChoices([
                    'Toute occasion' => 'Toute occasion',
                    'Parfum de jour' => 'Parfum de jour',
                    'Parfum de soirée' => 'Parfum de soirée',


                ])
                ->setHelp('Sélectionnez l\'occasion.')
                ->autocomplete(),
            ChoiceField::new('intensity', 'Intensité')
                ->setChoices([
                    'Discret' => 'Discret',
                    'Modéré' => 'Modéré',
                    'Puissant' => 'Puissant',
                ])
                ->setHelp('Sélectionnez l\'intensité.')
                ->autocomplete(),
            ChoiceField::new('gender', 'Genre')
                ->setChoices([
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                    'Unisexe' => 'Unisexe',
                ])
                ->setHelp('Sélectionnez le genre.')
                ->autocomplete(),
            DateTimeField::new('created_at', 'Créé le')->onlyOnIndex(),
            DateTimeField::new('updated_at', 'Mis à jour le')->onlyOnIndex(),
        ];
    }
}

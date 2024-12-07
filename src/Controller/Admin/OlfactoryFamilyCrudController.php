<?php

namespace App\Controller\Admin;

use App\Entity\OlfactoryFamily;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OlfactoryFamilyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OlfactoryFamily::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Désignation'),
            TextEditorField::new('description', 'Description')->hideOnIndex(),
            ImageField::new('image_url', 'URL de l\'Image')
                ->setBasePath('img/olfactory_families/')
                ->setUploadDir('public/img/olfactory_families/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            AssociationField::new('product', 'Produits')->hideOnForm(), // Ajustez le nom de la relation si nécessaire
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Famille Olfactive')
            ->setEntityLabelInPlural('Familles Olfactives');
    }
}

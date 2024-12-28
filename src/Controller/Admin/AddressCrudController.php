<?php

namespace App\Controller\Admin;

use App\Entity\Address;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AddressCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Address::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom'),
            TextField::new('firstname', 'Prénom'),
            TextField::new('lastname', 'Nom de famille'),
            TextField::new('company', 'Entreprise')->hideOnIndex(),
            TextField::new('address', 'Adresse'),
            TextField::new('postal', 'Code Postal'),
            TextField::new('city', 'Ville'),
            TextField::new('country', 'Pays'),
            TextField::new('phone', 'Téléphone'),
            AssociationField::new('user', 'Utilisateur'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(100)  // Définir 100 éléments par page
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des adresses')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter une adresse')
            ->setPageTitle(Crud::PAGE_EDIT, "Modifier l'adresse")
            ->setPageTitle(Crud::PAGE_DETAIL, "Détails de l'adresse")
            ->setEntityLabelInSingular('Adresse')
            ->setEntityLabelInPlural('Adresses');
    }
}

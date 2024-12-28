<?php

namespace App\Controller\Admin;

use App\Entity\PaymentMethod;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField; // Pour les frais de paiement
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PaymentMethodCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PaymentMethod::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom de la Méthode de Paiement'),
            TextEditorField::new('description', 'Description')->hideOnIndex(),
            BooleanField::new('status', 'Statut')->setHelp('Indique si ce moyen de paiement est actif'),
            MoneyField::new('fee', 'Frais de Paiement') // Ajout du champ frais
                ->setCurrency('XOF') // Tu peux adapter la devise selon ton besoin
                ->setHelp('Indique les frais supplémentaires pour cette méthode de paiement'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(100)  // Définir 100 éléments par page
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des méthodes de paiement')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter une méthode de paiement')
            ->setPageTitle(Crud::PAGE_EDIT, "Modifier la méthode de paiement")
            ->setPageTitle(Crud::PAGE_DETAIL, "Détails de la méthode de paiement")
            ->setEntityLabelInSingular('Méthode de paiement')
            ->setEntityLabelInPlural('Méthodes de paiement');
    }
}

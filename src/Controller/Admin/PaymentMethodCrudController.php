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
            ->setEntityLabelInSingular('Méthode de Paiement')
            ->setEntityLabelInPlural('Méthodes de Paiement')
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestion des Méthodes de Paiement') // Ajout du titre de la page
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier la Méthode de Paiement');
    }
}

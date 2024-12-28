<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\Validator\Constraints\Image;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Component\Validator\Constraints\Image as ImageConstraint;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CarrierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Carrier::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // Masquer l'ID sur le formulaire
            TextField::new('name')->setLabel('Nom'),
            TextareaField::new('description')
                ->setLabel('Description'),
            MoneyField::new('price')->setLabel('Prix')->setCurrency('XOF'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(100)  // Définir 100 éléments par page
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des transporteurs')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un transporteur')
            ->setPageTitle(Crud::PAGE_EDIT, "Modifier le transporteur")
            ->setPageTitle(Crud::PAGE_DETAIL, "Détails du transporteur")
            ->setEntityLabelInSingular('Transporteur')
            ->setEntityLabelInPlural('Transporteurs');
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // Cache l'ID lors de la création ou de la modification
            EmailField::new('email'), // Champ email
            TextField::new('firstname', 'Prénom'), // Champ pour le prénom
            TextField::new('lastname', 'Nom'), // Champ pour le nom
            ArrayField::new('roles', 'Rôle'), // Affiche les rôles de l'utilisateur
            BooleanField::new('isVerified', 'Vérifié')->setHelp('Indique si l\'utilisateur est vérifié'), // Champ pour la vérification
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur') // Label au singulier
            ->setEntityLabelInPlural('Utilisateurs') // Label au pluriel
            ->setSearchFields(['email', 'firstname', 'lastname']); // Permet de rechercher par email, prénom ou nom
    }
}

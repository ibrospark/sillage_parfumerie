<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\PasswordField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use App\Form\AddressType;
use App\Form\BlogType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // ID de l'entité (généralement pour affichage uniquement)
            IdField::new('id')->onlyOnDetail(),

            // Champs de texte
            TextField::new('firstname')->setLabel('Prénom'),
            TextField::new('lastname')->setLabel('Nom'),

            // Email
            EmailField::new('email')->setLabel('Email'),

            // Mot de passe (à afficher lors de la création ou mise à jour)
            TextField::new('password')->setLabel('Mot de passe')
                ->onlyWhenCreating()
                ->setFormTypeOption('attr.type', 'password'),

            // Si vous ne voulez pas que le mot de passe soit visible lors de la modification, utilisez 'onlyWhenCreating'
            TextField::new('password')->setLabel('Mot de passe')
                ->onlyWhenUpdating()
                ->setFormTypeOption('attr.type', 'password')
                ->setHelp('Laissez vide pour ne pas changer le mot de passe'),

            // Rôles de l'utilisateur
            ChoiceField::new('roles')
                ->setChoices([
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ])
                ->setLabel('Rôles')
                ->allowMultipleChoices(),

            // Vérification de l'email
            BooleanField::new('isVerified')->setLabel('Email vérifié'),


        ];
    }
}

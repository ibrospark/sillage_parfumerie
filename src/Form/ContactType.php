<?php

// src/Form/ContactType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', ChoiceType::class, [
                'choices' => [
                    'Suivi de Commande' => '1',
                    'Conseils Parfums' => '2',
                    'Mon compte Client / Mes données Personnelles' => '3',
                    'Produit défectueux ou erreur dans ma commande' => '4',
                    'Retourner mon produit' => '5',
                    'Partenariats/Presse' => '6',
                    'Être vendu chez Jovoy' => '7',
                    'BtoB / Franchise Jovoy' => '8',
                    'Nous Rejoindre !' => '9',
                    'Autres sujets' => '10',
                ],
                'label' => 'Sujet'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse mail',
                'attr' => ['placeholder' => 'your@email.com']
            ])
            ->add('attachment', FileType::class, [
                'label' => 'Pièce jointe',
                'required' => false,
                'attr' => ['class' => 'filestyle'],
                'mapped' => false // pour gérer le fichier indépendamment de l'entité
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => ['placeholder' => 'Comment pouvons-nous vous aider ?', 'rows' => 3]
            ])
            ->add('gdprConsent', CheckboxType::class, [
                'label' => 'J\'accepte les conditions générales et la politique de confidentialité',
                'mapped' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}

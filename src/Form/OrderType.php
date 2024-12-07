<?php

// src/Form/OrderType.php
namespace App\Form;

use App\Entity\Order;
use App\Entity\Carrier;
use App\Entity\PaymentMethod;
use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', EntityType::class, [
                'class' => Address::class,
                'choice_label' => 'name', // suppose que vous avez une méthode pour obtenir l'adresse complète
                'expanded' => true,  // Afficher comme boutons radio
            ])
            ->add('carrier', EntityType::class, [
                'class' => Carrier::class,
                'choice_label' => 'name',
                'expanded' => true,  // Afficher comme boutons radio
            ])
            ->add('paymentMethod', EntityType::class, [
                'class' => PaymentMethod::class,
                'choice_label' => 'name',
                'expanded' => true,  // Afficher comme boutons radio
            ]);
        // ->add('submit', SubmitType::class, ['label' => 'Passer commande']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}

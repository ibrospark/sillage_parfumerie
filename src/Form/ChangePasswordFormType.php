<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Mot de passe actuel
            ->add('old_password', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Saisissez votre mot de passe actuel',
                    'autocomplete' => 'current-password',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre mot de passe actuel',
                    ]),
                ],
            ])
            // Nouveau mot de passe
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'first_options' => [
                    'label' => 'Nouveau mot de passe',
                    'attr' => ['autocomplete' => 'new-password'],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un nouveau mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                            'max' => 4096,
                        ]),
                        new NotCompromisedPassword([
                            'message' => 'Ce mot de passe a été exposé lors d\'une fuite de données, veuillez en choisir un autre.',
                        ]),
                        // Vérification que le nouveau mot de passe n'est pas identique à l'ancien
                        new Callback(function ($newPassword, ExecutionContextInterface $context) {
                            $form = $context->getRoot();
                            $oldPassword = $form->get('old_password')->getData();

                            if ($oldPassword === $newPassword) {
                                $context->buildViolation('Le nouveau mot de passe ne peut pas être identique à l\'ancien.')
                                    ->atPath('plainPassword')
                                    ->addViolation();
                            }
                        }),
                    ],
                ],
                'second_options' => [
                    'label' => 'Répéter le nouveau mot de passe',
                    'attr' => ['autocomplete' => 'new-password'],
                ],
            ]);

        // Ajouter un écouteur d'événements pour valider à la soumission
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $newPassword = $form->get('plainPassword')->getData();
            $oldPassword = $form->get('old_password')->getData();

            // Vérification que l'ancien et le nouveau mot de passe ne sont pas identiques
            if ($oldPassword === $newPassword) {
                $form->get('plainPassword')->addError(new FormError('Le nouveau mot de passe ne peut pas être identique à l\'ancien.'));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}

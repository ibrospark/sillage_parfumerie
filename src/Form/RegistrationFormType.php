<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre prénom',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre prénom doit contenir au moins {{ limit }} caractères',
                        'max' => 255,
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s-]+$/',
                        'message' => 'Le prénom ne doit contenir que des lettres, des espaces et des tirets.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Jean',
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom de famille',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre nom de famille',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom de famille doit contenir au moins {{ limit }} caractères',
                        'max' => 255,
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s-]+$/',
                        'message' => 'Le nom de famille ne doit contenir que des lettres, des espaces et des tirets.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Passe',
                ],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre adresse e-mail',
                    ]),
                    new Email([
                        'message' => 'Veuillez entrer une adresse e-mail valide',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'jean.passe@hotgmail.com',
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'attr' => ['placeholder' => 'Saisir mot de passe'],
                ],
                'second_options' => [
                    'label' => 'Répétez mot de passe',
                    'attr' => ['placeholder' => 'Confirmer mot de passe'],
                ],
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => '/[A-Z]/',
                        'message' => 'Le mot de passe doit contenir au moins une majuscule.',
                    ]),
                    new Regex([
                        'pattern' => '/[a-z]/',
                        'message' => 'Le mot de passe doit contenir au moins une minuscule.',
                    ]),
                    new Regex([
                        'pattern' => '/[0-9]/',
                        'message' => 'Le mot de passe doit contenir au moins un chiffre.',
                    ]),
                    // new Regex([
                    //     'pattern' => '/[\W_]/',
                    //     'message' => 'Le mot de passe doit contenir au moins un caractère spécial.',
                    // ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos termes.',
                    ]),
                ],
                'label' => 'J\'ai lu et j\'accepte les termes',
                'label_attr' => [
                    'class' => 'form-check-label' // Optionnel, pour ajouter une classe CSS
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

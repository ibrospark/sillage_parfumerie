<?php

namespace App\Form;

use App\Model\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('string', TextType::class, [
                'required' => false,
                'label' => "Que-recherchez-vous?"
            ])
            ->add('categories', ChoiceType::class, [
                'choices' => $options['categories'],
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('olfactoryNotes', ChoiceType::class, [
                'choices' => $options['olfactory_notes'],
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('olfactoryFamilies', ChoiceType::class, [
                'choices' => $options['olfactory_families'],
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])


            ->add('brands', ChoiceType::class, [
                'choices' => $options['brands'], // Populate with available brands
                'multiple' => true,
                'expanded' => true, // For checkboxes
            ])

            ->add('featured', null, [
                'required' => false,
            ])
            ->add('filter', SubmitType::class, [
                'label' => 'Filter',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'categories' => [],
            'olfactory_notes' => [],
            'olfactory_families' => [],
            'brands' => [], // Add brands to the options
        ]);
    }
}

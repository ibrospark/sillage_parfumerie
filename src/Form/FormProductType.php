<?php

namespace App\Form;

use App\Model\FilterProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('string', TextType::class, [
                'required' => false,
                'label' => "Que-recherchez-vous?"
            ])
            ->add('categories', ChoiceType::class, [
                'choices' => $this->getChoices($options['categories']),
                'choice_label' => function ($category) {
                    return $category->getName(); // Affiche le nom de la catégorie
                },
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('olfactoryNotes', ChoiceType::class, [
                'choices' => $this->getChoices($options['olfactory_notes']),
                'choice_label' => function ($olfactoryNote) {
                    return $olfactoryNote->getName(); // Affiche le nom de la note olfactive
                },
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('olfactoryFamilies', ChoiceType::class, [
                'choices' => $this->getChoices($options['olfactory_families']),
                'choice_label' => function ($olfactoryFamily) {
                    return $olfactoryFamily->getName(); // Affiche le nom de la famille olfactive
                },
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('brands', ChoiceType::class, [
                'choices' => $this->getChoices($options['brands']),
                'choice_label' => function ($brand) {
                    return $brand->getName(); // Affiche le nom de la marque
                },
                'multiple' => true,
                'expanded' => true, // Pour des cases à cocher
            ])
            ->add('featured', null, [
                'required' => false,
            ])
            ->add('filter', SubmitType::class, [
                'label' => 'Filter',
            ]);
    }

    /**
     * Cette méthode permet de générer les choix pour les champs ChoiceType.
     * Les clés sont les labels (noms), et les valeurs sont les objets complets des entités.
     */
    private function getChoices(array $entities)
    {
        $choices = [];
        foreach ($entities as $entity) {
            $choices[$entity->getName()] = $entity;  // Nous utilisons l'objet complet, pas seulement l'ID
        }

        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FilterProduct::class,
            'categories' => [],
            'olfactory_notes' => [],
            'olfactory_families' => [],
            'brands' => [], // Ajoutez les marques aux options
        ]);
    }
}

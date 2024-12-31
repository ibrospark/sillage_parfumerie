<?php

namespace App\Controller\Admin;

use App\Entity\Slider;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SliderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Slider::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // Champ pour choisir la source vidéo (URL ou upload)
        $videoSourceField = ChoiceField::new('videoSourceType', 'Source Vidéo')
            ->setChoices([
                'URL' => 'url',
                // 'Lien youtube' => 'youtube',
                'Upload' => 'upload'

            ])
            ->setHelp('Choisissez le type de source vidéo.');

        // Champ pour l'URL de la vidéo (affiché uniquement si "URL" est choisi)
        $videoUrlField = TextField::new('videoUrl', 'URL de la Vidéo')
            ->setFormType(TextType::class)
            ->onlyOnForms()
            ->setHelp('Entrez l\'URL de la vidéo');

        // Champ pour le fichier vidéo (affiché uniquement si "Upload" est choisi)
        $videoFileField = TextField::new('videoFile', 'Fichier Vidéo')
            ->setFormType(VichFileType::class)
            ->setFormTypeOptions([
                'allow_delete' => true,
                'download_uri' => true,
                'download_label' => 'Télécharger',
                'attr' => [
                    'accept' => 'video/*',
                ],
            ])
            ->onlyOnForms()
            ->setHelp('Téléchargez le fichier vidéo');

        // Affichage conditionnel des champs en fonction du choix de la source vidéo
        if ($pageName === Crud::PAGE_NEW || $pageName === Crud::PAGE_EDIT) {
            // Si l'utilisateur choisit "URL", afficher le champ pour l'URL
            $videoSourceField->addCssClass('video-source-url')
                ->setFormTypeOption('attr', ['data-video-source' => 'url']);

            // Si l'utilisateur choisit "Upload", afficher le champ pour le fichier vidéo
            $videoFileField->addCssClass('video-source-upload')
                ->setFormTypeOption('attr', ['data-video-source' => 'upload']);
        }

        return [
            TextField::new('title', 'Titre'),
            TextEditorField::new('description', 'Description')->hideOnIndex(),
            TextField::new('videoFileName', 'Nom du fichier')->onlyOnIndex(),
            $videoSourceField,
            $videoUrlField,
            $videoFileField,
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(100)  // Définir 100 éléments par page
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des slides')
            ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un slide')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un slide')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails du slide')
            ->setEntityLabelInSingular('Slide')
            ->setEntityLabelInPlural('Slides');
    }
}

<?php

namespace App\Entity;

use App\Repository\SliderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: SliderRepository::class)]
#[Vich\Uploadable]  // Cette annotation indique que l'entité est uploadable par VichUploader
#[HasLifecycleCallbacks]  // Active les callbacks de Doctrine pour cette entité
class Slider
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    private ?string $videoSourceType = null; // Nouveau champ pour définir la source (URL ou Upload)

    // Ce champ stockera le nom du fichier vidéo téléversé
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $videoFileName = null;

    // Ce champ est utilisé pour le téléversement du fichier vidéo (non mappé dans la base de données)
    #[Vich\UploadableField(mapping: 'slider_videos', fileNameProperty: 'videoFileName')]
    #[Assert\File(
        maxSize: '50M',  // Limite de taille du fichier
        mimeTypes: ['video/mp4', 'video/mpeg', 'video/quicktime'],
        mimeTypesMessage: 'Veuillez télécharger un fichier vidéo valide (MP4, MPEG, MOV)'
    )]
    private ?File $videoFile = null;

    // Champ pour l'URL de la vidéo si l'utilisateur choisit d'utiliser une URL
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url]  // Assurez-vous que c'est une URL valide
    private ?string $videoUrl = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    // Garder uniquement `updated_at`
    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;


    public function __construct()
    {
        // Initialisation des timestamps
        $this->created_at = new \DateTimeImmutable();
        $this->updated_at = new \DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getVideoSourceType(): ?string
    {
        return $this->videoSourceType;
    }

    public function setVideoSourceType(string $videoSourceType): static
    {
        $this->videoSourceType = $videoSourceType;

        return $this;
    }

    public function getVideoFileName(): ?string
    {
        return $this->videoFileName;
    }

    public function setVideoFileName(?string $videoFileName): static
    {
        $this->videoFileName = $videoFileName;

        return $this;
    }

    public function getVideoFile(): ?File
    {
        return $this->videoFile;
    }

    public function setVideoFile(?File $videoFile = null): static
    {
        $this->videoFile = $videoFile;

        // Obligatoire pour VichUploader : définir une date de mise à jour pour rafraîchir l'entité en cas de changement de fichier
        if ($videoFile) {
            $this->updated_at = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }

    public function setVideoUrl(?string $videoUrl): static
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('%s - %s', $this->title ?? 'No Title', $this->description ?? 'No Description');
    }

    // Méthode pour supprimer la vidéo associée lors de la suppression de l'entité
    /**
     * @ORM\PreRemove
     */
    public function removeVideoFile(): void
    {
        // Vérifier si le fichier vidéo est présent et supprimer le fichier
        if ($this->videoFileName) {
            // Le chemin du fichier vidéo dans le répertoire public
            $videoFilePath = __DIR__ . '/../../public/videos/' . $this->videoFileName;
            if (file_exists($videoFilePath)) {
                unlink($videoFilePath);  // Supprimer le fichier vidéo
            }
        }
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}

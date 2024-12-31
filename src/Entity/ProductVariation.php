<?php

namespace App\Entity;

use App\Repository\ProductVariationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductVariationRepository::class)]
class ProductVariation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'productVariations')]
    private ?Product $product = null;

    #[ORM\Column]
    private ?float $regular_price = null;

    #[ORM\Column]
    private ?float $sale_price = null;

    #[ORM\Column]
    private ?int $stock_quantity = null;

    #[ORM\Column(length: 255)]
    private ?string $capacity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_url = '';

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;


    public function __construct()
    {
        // Initialisation des timestamps
        $this->created_at = new \DateTimeImmutable(); // Date actuelle lors de la création
        $this->updated_at = new \DateTimeImmutable(); // Initialisé à la même valeur au départ

        // Vérifier si l'image de la variation est vide, sinon, l'attribuer à celle du produit
        if (empty($this->image_url) && $this->product) {
            $this->image_url = $this->product->getImageUrl();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getRegularPrice(): ?float
    {
        return $this->regular_price;
    }

    public function setRegularPrice(float $regular_price): static
    {
        $this->regular_price = $regular_price;

        return $this;
    }

    public function getSalePrice(): ?float
    {
        return $this->sale_price;
    }

    public function setSalePrice(float $sale_price): static
    {
        $this->sale_price = $sale_price;

        return $this;
    }

    public function getStockQuantity(): ?int
    {
        return $this->stock_quantity;
    }

    public function setStockQuantity(int $stock_quantity): static
    {
        $this->stock_quantity = $stock_quantity;

        return $this;
    }

    public function getCapacity(): ?string
    {
        return $this->capacity;
    }

    public function setCapacity(string $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }
    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->image_url = $imageUrl ?? 'empty.jpg';
        return $this;
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
    public function __toString(): string
    {
        // Vérifier si le produit est associé et ajouter son nom au string
        $productName = $this->product ? $this->product->getName() : 'Produit inconnu';

        // Combiner le nom du produit, la capacité et le prix
        return $productName . ' - ' . $this->capacity . ' - ' . $this->regular_price . ' F';
    }
    /**
     * @ORM\PreRemove
     */
    public function removeImageFile(): void
    {
        // Vérifier si le fichier image est présent et supprimer le fichier
        if ($this->image_url && $this->image_url !== 'empty.jpg') {
            // Le chemin du fichier image dans le répertoire public
            $imageFilePath = __DIR__ . '/../../public/img/products/' . $this->image_url;
            if (file_exists($imageFilePath)) {
                unlink($imageFilePath);  // Supprimer le fichier image
            }
        }
    }
}

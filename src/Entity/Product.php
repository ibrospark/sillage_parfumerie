<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $regular_price = null;

    #[ORM\Column]
    private ?float $sale_price = null;

    #[ORM\Column]
    private ?int $stock_quantity = null;

    #[ORM\Column(length: 255)]
    private ?string $capacity = null;

    #[ORM\Column(length: 255)]
    private ?string $weight = null;

    #[ORM\Column(length: 255)]
    private ?string $image_url = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Brand $brand = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?OlfactoryFamily $olfactoryFamily = null;

    #[ORM\Column]
    private ?int $status = 1;

    #[ORM\Column]
    private ?bool $featured = false;

    #[ORM\Column]
    private ?bool $is_in_home = false;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'products_head_note')]
    private ?OlfactoryNote $head_note = null;

    #[ORM\ManyToOne(inversedBy: 'products_heart_note')]
    private ?OlfactoryNote $heart_note = null;

    #[ORM\ManyToOne(inversedBy: 'products_background_note')]
    private ?OlfactoryNote $background_note = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: OrderItem::class)]
    private Collection $orderItems; // À ajouter dans Product

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
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

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(string $weight): static
    {
        $this->weight = $weight;
        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(string $image_url): static
    {
        $this->image_url = $image_url;
        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;
        return $this;
    }

    public function getOlfactoryFamily(): ?OlfactoryFamily
    {
        return $this->olfactoryFamily;
    }

    public function setOlfactoryFamily(?OlfactoryFamily $olfactoryFamily): static
    {
        $this->olfactoryFamily = $olfactoryFamily;
        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function isFeatured(): ?bool
    {
        return $this->featured;
    }

    public function setFeatured(bool $featured): static
    {
        $this->featured = $featured;
        return $this;
    }

    public function isInHome(): ?bool
    {
        return $this->is_in_home;
    }

    public function setInHome(bool $is_in_home): static
    {
        $this->is_in_home = $is_in_home;
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

    public function getHeadNote(): ?OlfactoryNote
    {
        return $this->head_note;
    }

    public function setHeadNote(?OlfactoryNote $head_note): static
    {
        $this->head_note = $head_note;
        return $this;
    }

    public function getHeartNote(): ?OlfactoryNote
    {
        return $this->heart_note;
    }

    public function setHeartNote(?OlfactoryNote $heart_note): static
    {
        $this->heart_note = $heart_note;
        return $this;
    }

    public function getBackgroundNote(): ?OlfactoryNote
    {
        return $this->background_note;
    }

    public function setBackgroundNote(?OlfactoryNote $background_note): static
    {
        $this->background_note = $background_note;
        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? 'Product'; // Fallback to 'Product' if name is null
    }
}

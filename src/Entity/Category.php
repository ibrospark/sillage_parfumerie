<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    // Utilisation d'un tableau pour stocker plusieurs types de visibilité
    #[ORM\Column(type: "array", nullable: true)]
    private ?array $visibility_types = [];

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'category')]
    private Collection $products;

    #[ORM\Column]
    private ?bool $is_in_menu = null;

    #[ORM\Column(length: 255)]
    private ?string $image_url = null;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }
    public function getVisibilityTypes(): ?array
    {
        return $this->visibility_types;
    }

    public function setVisibilityTypes(?array $visibility_types): self
    {
        $this->visibility_types = $visibility_types;
        return $this;
    }
    public function __toString(): string
    {
        return $this->name ?: ''; // Assure que même si name est null, on retourne une chaîne vide
    }

     // Accesseur (getter) pour isInMenu
     public function getIsInMenu(): bool
     {
         return $this->is_in_menu;
     }
 
     // Modificateur (setter) pour is_in_menu
     public function setIsInMenu(bool $is_in_menu): self
     {
         $this->is_in_menu = $is_in_menu;
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
 
 
}

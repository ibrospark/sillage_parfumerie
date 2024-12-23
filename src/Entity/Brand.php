<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
class Brand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'brand')]
    private Collection $products;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cover_url = '';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo_url = '';

    #[ORM\Column(type: Types::TEXT)]
    private ?string $excerpt = null;

    // Utilisation d'un tableau pour stocker plusieurs types de visibilité
    #[ORM\Column(type: "array", nullable: true)]
    private ?array $visibility_types = [];


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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

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
            $product->setBrand($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getBrand() === $this) {
                $product->setBrand(null);
            }
        }

        return $this;
    }

    public function getCoverUrl(): ?string
    {
        return $this->cover_url;
    }

    public function setCoverUrl(?string $cover_url): self
    {
        $this->cover_url = $cover_url ?? 'empty.jpg';
        return $this;
    }


    public function getLogoUrl(): ?string
    {
        return $this->logo_url;
    }


    public function setLogoUrl(?string $logo_url): self
    {
        $this->logo_url = $logo_url ?? 'empty.jpg';
        return $this;
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function setExcerpt(string $excerpt): static
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?: ''; // Assure que même si name est null, on retourne une chaîne vide
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
}

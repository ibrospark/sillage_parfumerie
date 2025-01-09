<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
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
    #[ORM\Column(type: 'float', nullable: true)]
    #[Assert\NotNull(message: "Le prix régulier ne peut pas être nul.")]
    private ?float $regular_price = null;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Assert\NotNull(message: "Le prix promotionnel ne peut pas être nul.")]
    #[Assert\LessThan(
        propertyPath: 'regular_price',
        message: "Le prix promotionnel doit être inférieur au prix régulier."
    )]
    private ?float $sale_price = null;

    #[ORM\Column]
    private ?int $stock_quantity = null;

    #[ORM\Column(length: 255)]
    private ?string $capacity = null;

    #[ORM\Column(length: 255)]
    private ?string $weight = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_url = '';

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private ?Brand $brand = null;






    #[ORM\Column(type: "string", nullable: true)]
    private ?string $status = null;

    // Utilisation d'un tableau pour stocker plusieurs types de visibilité
    #[ORM\Column(type: "array", nullable: true)]
    private ?array $visibility_types = [];

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: OrderItem::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private Collection $orderItems; // À ajouter dans Product

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $season = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $occasion = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $intensity = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $gender = null;

    /**
     * @var Collection<int, ProductVariation>
     */
    #[ORM\OneToMany(targetEntity: ProductVariation::class, mappedBy: 'product', cascade: ['remove'])]
    private Collection $productVariations;

    #[ORM\Column(length: 255)]
    private ?string $concentration = null;

    /**
     * @var Collection<int, OlfactoryNote>
     */
    #[ORM\ManyToMany(targetEntity: OlfactoryNote::class, inversedBy: 'products')]
    #[ORM\JoinTable(name: 'product_head_note')]
    private Collection $head_note;

    /**
     * @var Collection<int, OlfactoryNote>
     */
    #[ORM\ManyToMany(targetEntity: OlfactoryNote::class, inversedBy: 'products')]
    #[ORM\JoinTable(name: 'product_heart_note')]
    private Collection $heart_note;

    /**
     * @var Collection<int, OlfactoryNote>
     */
    #[ORM\ManyToMany(targetEntity: OlfactoryNote::class, inversedBy: 'products')]
    #[ORM\JoinTable(name: 'product_background_note')]
    private Collection $background_note;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'products')]
    private Collection $category;

    /**
     * @var Collection<int, OlfactoryFamily>
     */
    #[ORM\ManyToMany(targetEntity: OlfactoryFamily::class, inversedBy: 'products')]
    private Collection $olfactoryFamily;


    public function __construct()
    {
        // Initialisation des timestamps
        $this->created_at = new \DateTimeImmutable(); // Date actuelle lors de la création
        $this->updated_at = new \DateTimeImmutable(); // Initialisé à la même valeur au départ
        $this->orderItems = new ArrayCollection();
        $this->productVariations = new ArrayCollection();
        $this->head_note = new ArrayCollection();
        $this->heart_note = new ArrayCollection();
        $this->background_note = new ArrayCollection();
        $this->category = new ArrayCollection();
        $this->olfactoryFamily = new ArrayCollection();
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
        // Mettre à jour le nom avec la concentration si elle est définie
        $this->name = $name;

        // Si la concentration est définie, on s'assure que le format est "name - concentration"
        if ($this->concentration) {
            $this->name = $name . ' - ' . $this->concentration;
        }

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

    public function setImageUrl(?string $imageUrl): self
    {
        $this->image_url = $imageUrl ?? 'empty.jpg';
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




    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status ?? '0';
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


    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setProduct($this);
        }

        return $this;
    }
    public function getSeason(): ?string
    {
        return $this->season;
    }

    public function setSeason(string $season): static
    {
        $this->season = $season;
        return $this;
    }

    public function getOccasion(): ?string
    {
        return $this->occasion;
    }

    public function setOccasion(string $occasion): static
    {
        $this->occasion = $occasion;
        return $this;
    }

    public function getIntensity(): ?string
    {
        return $this->intensity;
    }

    public function setIntensity(string $intensity): static
    {
        $this->intensity = $intensity;
        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;
        return $this;
    }
    // public function removeOrderItem(OrderItem $orderItem): static
    // {
    //     if ($this->orderItems->removeElement($orderItem)) {
    //         // set the owning side to null (unless already changed)
    //         if ($orderItem->getProduct() === $this) {
    //             $orderItem->setProduct(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, ProductVariation>
     */
    public function getProductVariations(): Collection
    {
        return $this->productVariations;
    }

    public function addProductVariation(ProductVariation $productVariation): static
    {
        if (!$this->productVariations->contains($productVariation)) {
            $this->productVariations->add($productVariation);
            $productVariation->setProduct($this);
        }

        return $this;
    }

    public function removeProductVariation(ProductVariation $productVariation): static
    {
        if ($this->productVariations->removeElement($productVariation)) {
            // set the owning side to null (unless already changed)
            if ($productVariation->getProduct() === $this) {
                $productVariation->setProduct(null);
            }
        }

        return $this;
    }

    public function getConcentration(): ?string
    {
        return $this->concentration;
    }

    public function setConcentration(string $concentration): static
    {
        $this->concentration = $concentration;

        // Si le nom existe déjà, on met à jour le nom pour être au format "name - concentration"
        if ($this->name) {
            // On utilise uniquement la partie avant le tiret (le nom) et ajoute la concentration
            $this->name = explode(' - ', $this->name)[0] . ' - ' . $concentration;
        }

        return $this;
    }
    /**
     * @ORM\PreRemove
     */
    public function removeImageFile(): void
    {
        if ($this->image_url && $this->image_url !== 'empty.jpg' || $this->image_url !== 'empty.png') {
            $imageFilePath = __DIR__ . '/../../public/img/products/' . $this->image_url;
            if (file_exists($imageFilePath)) {
                unlink($imageFilePath);
            }
        }
    }

    /**
     * @return Collection<int, OlfactoryNote>
     */
    public function getHeadNote(): Collection
    {
        return $this->head_note;
    }

    public function addHeadNote(OlfactoryNote $headNote): static
    {
        if (!$this->head_note->contains($headNote)) {
            $this->head_note->add($headNote);
        }

        return $this;
    }

    public function removeHeadNote(OlfactoryNote $headNote): static
    {
        $this->head_note->removeElement($headNote);

        return $this;
    }

    /**
     * @return Collection<int, OlfactoryNote>
     */
    public function getHeartNote(): Collection
    {
        return $this->heart_note;
    }

    public function addHeartNote(OlfactoryNote $heartNote): static
    {
        if (!$this->heart_note->contains($heartNote)) {
            $this->heart_note->add($heartNote);
        }

        return $this;
    }

    public function removeHeartNote(OlfactoryNote $heartNote): static
    {
        $this->heart_note->removeElement($heartNote);

        return $this;
    }

    /**
     * @return Collection<int, OlfactoryNote>
     */
    public function getBackgroundNote(): Collection
    {
        return $this->background_note;
    }

    public function addBackgroundNote(OlfactoryNote $backgroundNote): static
    {
        if (!$this->background_note->contains($backgroundNote)) {
            $this->background_note->add($backgroundNote);
        }

        return $this;
    }

    public function removeBackgroundNote(OlfactoryNote $backgroundNote): static
    {
        $this->background_note->removeElement($backgroundNote);

        return $this;
    }

    public function __toString()
    {
        return $this->name ?? '';
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, OlfactoryFamily>
     */
    public function getOlfactoryFamily(): Collection
    {
        return $this->olfactoryFamily;
    }

    public function addOlfactoryFamily(OlfactoryFamily $olfactoryFamily): static
    {
        if (!$this->olfactoryFamily->contains($olfactoryFamily)) {
            $this->olfactoryFamily->add($olfactoryFamily);
        }

        return $this;
    }

    public function removeOlfactoryFamily(OlfactoryFamily $olfactoryFamily): static
    {
        $this->olfactoryFamily->removeElement($olfactoryFamily);

        return $this;
    }
}

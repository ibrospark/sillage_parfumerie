<?php

namespace App\Entity;

use App\Repository\OlfactoryNoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OlfactoryNoteRepository::class)]
class OlfactoryNote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $imageUrl = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'head_note')]
    private Collection $products_head_note;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'heart_note')]
    private Collection $products_heart_note;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'background_note')]
    private Collection $products_background_note;




    public function __construct()
    {
        $this->products_head_note = new ArrayCollection();
        $this->products_heart_note = new ArrayCollection();
        $this->products_background_note = new ArrayCollection();
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

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductsHeadNote(): Collection
    {
        return $this->products_head_note;
    }

    public function addProductsHeadNote(Product $productsHeadNote): static
    {
        if (!$this->products_head_note->contains($productsHeadNote)) {
            $this->products_head_note->add($productsHeadNote);
            $productsHeadNote->setHeadNote($this);
        }

        return $this;
    }

    public function removeProductsHeadNote(Product $productsHeadNote): static
    {
        if ($this->products_head_note->removeElement($productsHeadNote)) {
            // set the owning side to null (unless already changed)
            if ($productsHeadNote->getHeadNote() === $this) {
                $productsHeadNote->setHeadNote(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductsHeartNote(): Collection
    {
        return $this->products_heart_note;
    }

    public function addProductsHeartNote(Product $productsHeartNote): static
    {
        if (!$this->products_heart_note->contains($productsHeartNote)) {
            $this->products_heart_note->add($productsHeartNote);
            $productsHeartNote->setHeartNote($this);
        }

        return $this;
    }

    public function removeProductsHeartNote(Product $productsHeartNote): static
    {
        if ($this->products_heart_note->removeElement($productsHeartNote)) {
            // set the owning side to null (unless already changed)
            if ($productsHeartNote->getHeartNote() === $this) {
                $productsHeartNote->setHeartNote(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductsBackgroundNote(): Collection
    {
        return $this->products_background_note;
    }

    public function addProductsBackgroundNote(Product $productsBackgroundNote): static
    {
        if (!$this->products_background_note->contains($productsBackgroundNote)) {
            $this->products_background_note->add($productsBackgroundNote);
            $productsBackgroundNote->setBackgroundNote($this);
        }

        return $this;
    }

    public function removeProductsBackgroundNote(Product $productsBackgroundNote): static
    {
        if ($this->products_background_note->removeElement($productsBackgroundNote)) {
            // set the owning side to null (unless already changed)
            if ($productsBackgroundNote->getBackgroundNote() === $this) {
                $productsBackgroundNote->setBackgroundNote(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->name ?? 'Unnamed Olfactory Note';
    }
}

<?php

namespace App\Model;

class Search
{
    private ?string $string = null;
    private array $categories = [];
    private ?array $olfactoryNotes = [];
    private ?array $olfactoryFamilies = [];
    private ?float $minPrice = null;
    private ?float $maxPrice = null;
    private ?array $brands = [];
    private ?bool $featured = null;

    public function getString(): ?string
    {
        return $this->string;
    }

    public function setString(?string $string): self
    {
        $this->string = $string;
        return $this;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    public function getOlfactoryNotes(): ?array
    {
        return $this->olfactoryNotes;
    }

    public function setOlfactoryNotes(array $olfactoryNotes): self
    {
        $this->olfactoryNotes = $olfactoryNotes;
        return $this;
    }

    public function getOlfactoryFamilies(): ?array
    {
        return $this->olfactoryFamilies;
    }

    public function setOlfactoryFamilies(array $olfactoryFamilies): self
    {
        $this->olfactoryFamilies = $olfactoryFamilies;
        return $this;
    }

    public function getMinPrice(): ?float
    {
        return $this->minPrice;
    }

    public function setMinPrice(?float $minPrice): self
    {
        $this->minPrice = $minPrice;
        return $this;
    }

    public function getMaxPrice(): ?float
    {
        return $this->maxPrice;
    }

    public function setMaxPrice(?float $maxPrice): self
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    public function getBrands(): ?array
    {
        return $this->brands;
    }

    public function setBrands(array $brands): self
    {
        $this->brands = $brands;
        return $this;
    }
    public function isFeatured(): ?bool
    {
        return $this->featured;
    }

    public function setFeatured(?bool $featured): self
    {
        $this->featured = $featured;
        return $this;
    }

    public function __toString(): string
    {
        return sprintf(
            'Search: [string: %s, categories: %s, olfactoryNotes: %s, olfactoryFamilies: %s, minPrice: %s, maxPrice: %s, brands: %s, featured: %s]',
            $this->string,
            implode(', ', $this->categories),
            implode(', ', $this->olfactoryNotes),
            implode(', ', $this->olfactoryFamilies),
            $this->minPrice,
            $this->maxPrice,
            implode(', ', $this->brands), // Include brands
            $this->featured ? 'true' : 'false'
        );
    }
}

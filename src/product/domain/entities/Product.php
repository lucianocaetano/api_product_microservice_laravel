<?php

namespace Src\product\domain\entities;

class Product
{
    public function __construct(
        private string $id,
        private string $slug,
        private string $name,
        private string $description,
        private int $quantity,
        private string $price,
        private string $currency,
        private string $category_slug,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCategorySlug(): string
    {
        return $this->category_slug;
    }
}

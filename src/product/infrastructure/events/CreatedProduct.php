<?php

namespace Src\product\infrastructure\events;

class CreatedProduct
{
    public function __construct(
        private string $id,
        private string $slug,
        private string $name,
        private string $description,
        private int $quantity,
        private int $amount,
        private string $currency,
        private string $category_slug
    ) {
        //
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getCategorySlug(): string
    {
        return $this->category_slug;
    }
}

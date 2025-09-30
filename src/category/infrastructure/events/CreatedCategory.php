<?php

namespace Src\category\infrastructure\events;

class CreatedCategory
{
    public function __construct(
        private string $id,
        private string $slug,
        private string $name,
        private string|null $parent,
    ){}

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

    public function getParent(): string|null
    {
        return $this->parent;
    }
}

<?php

namespace Src\category\infrastructure\events;

class DeletedCategory
{
    public function __construct(
        private string $slug,
    ){}

    public function getSlug(): string
    {
        return $this->slug;
    }
}

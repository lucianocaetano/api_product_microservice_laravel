<?php

namespace Src\product\infrastructure\events;

class DeletedProduct
{
    public function __construct(
        private string $id,
    ) {
        //
    }

    public function getId(): string
    {
        return $this->id;
    }
}

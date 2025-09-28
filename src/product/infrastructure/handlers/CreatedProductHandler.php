<?php

namespace Src\product\infrastructure\handlers;

use Src\product\application\contracts\in\CreateProductUseCasePort;
use Src\product\domain\entities\Product;
use Src\product\infrastructure\events\CreatedProduct;

class CreatedProductHandler
{
    public function __construct(
        private CreateProductUseCasePort $createProductUseCase
    ) {
        //
    }

    public function handle(CreatedProduct $event): void
    {
        $this->createProductUseCase->execute(

            new Product(
                $event->getId(),
                $event->getSlug(),
                $event->getName(),
                $event->getDescription(),
                $event->getQuantity(),
                $event->getAmount(),
                $event->getCurrency(),
                $event->getCategoryId()
            )
        );
    }
}

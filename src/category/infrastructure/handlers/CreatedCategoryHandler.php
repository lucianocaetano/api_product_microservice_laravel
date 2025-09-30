<?php

namespace Src\product\infrastructure\handlers;

use Src\category\application\contracts\in\CreateCategoryUseCasePort;
use Src\product\domain\entities\Product;
use Src\product\infrastructure\events\CreatedProduct;

class CreatedCategoryHandler
{
    public function __construct(
        private CreateCategoryUseCasePort $createCategoryUseCase
    ) {}

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
                $event->getCategorySlug()
            )
        );
    }
}

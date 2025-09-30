<?php

namespace Src\product\infrastructure\handlers;

use Src\product\application\contracts\in\UpdateProductUseCasePort;
use Src\product\domain\entities\Product;
use Src\product\infrastructure\events\UpdatedProduct;

class UpdatedProductHandler
{
    public function __construct(
        private UpdateProductUseCasePort $updateProductUseCase
    ) {
        //
    }

    public function handle(UpdatedProduct $event): void
    {
        $this->updateProductUseCase->execute(

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

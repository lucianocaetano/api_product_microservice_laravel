<?php

namespace Src\product\infrastructure\handlers;

use Src\product\application\contracts\in\DeleteProductUseCasePort;
use Src\product\infrastructure\events\DeletedProduct;

class DeletedProductHandler
{
    public function __construct(
        private DeleteProductUseCasePort $deleteProductUseCasePort
    ) {
        //
    }

    public function handle(DeletedProduct $event): void
    {
        $this->deleteProductUseCasePort->execute(
            $event->getId()
        );
    }
}

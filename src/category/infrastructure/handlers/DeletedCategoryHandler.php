<?php

namespace Src\category\infrastructure\handlers;

use Src\category\application\contracts\in\DeleteCategoryUseCasePort;
use Src\category\infrastructure\events\DeletedCategory;

class DeletedCategoryHandler
{
    public function __construct(
        private DeleteCategoryUseCasePort $deleteCategoryUseCase
    ) {}

    public function handle(DeletedCategory $event): void
    {
        $this->deleteCategoryUseCase->execute(
            $event->getSlug()
        );
    }
}

<?php

namespace Src\category\infrastructure\handlers;

use Src\category\application\contracts\in\CreateCategoryUseCasePort;
use Src\category\domain\entities\Category;
use Src\category\infrastructure\events\CreatedCategory;

class CreatedCategoryHandler
{
    public function __construct(
        private CreateCategoryUseCasePort $createCategoryUseCase
    ) {}

    public function handle(CreatedCategory $event): void
    {
        $this->createCategoryUseCase->execute(

            new Category(
                $event->getId(),
                $event->getSlug(),
                $event->getName(),
                $event->getParent()
            )
        );
    }
}

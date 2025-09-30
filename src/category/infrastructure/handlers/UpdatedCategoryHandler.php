<?php

namespace Src\category\infrastructure\handlers;

use Src\category\application\contracts\in\UpdateCategoryUseCasePort;
use Src\category\domain\entities\Category;
use Src\category\infrastructure\events\UpdatedCategory;

class UpdatedCategoryHandler
{
    public function __construct(
        private UpdateCategoryUseCasePort $updateCategoryUseCase
    ) {}

    public function handle(UpdatedCategory $event): void
    {
        $this->updateCategoryUseCase->execute(
            new Category(
                $event->getId(),
                $event->getSlug(),
                $event->getName(),
                $event->getParent()
            )
        );
    }
}

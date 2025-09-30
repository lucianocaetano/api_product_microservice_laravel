<?php

namespace Src\category\application\use_cases;

use Src\category\application\contracts\in\CreateCategoryUseCasePort;
use Src\category\application\contracts\out\CategoryRepository;
use Src\category\domain\entities\Category;

class CreateCategoryUseCase implements CreateCategoryUseCasePort
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ){}

    public function execute(Category $category): void
    {
        $this->categoryRepository->save($category);
    }
}

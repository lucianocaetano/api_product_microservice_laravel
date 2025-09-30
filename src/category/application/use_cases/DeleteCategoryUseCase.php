<?php

namespace Src\category\application\use_cases;

use Src\category\application\contracts\in\DeleteCategoryUseCasePort;
use Src\category\application\contracts\out\CategoryRepository;

class DeleteCategoryUseCase implements DeleteCategoryUseCasePort
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ){}

    public function execute(string $slug): void
    {
        $this->categoryRepository->delete($slug);
    }
}

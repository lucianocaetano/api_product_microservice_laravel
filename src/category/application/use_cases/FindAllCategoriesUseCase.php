<?php

namespace Src\category\application\use_cases;

use Src\category\application\contracts\in\FindAllCategoriesUseCasePort;
use Src\category\application\contracts\out\CategoryRepository;

class FindAllCategoriesUseCase implements FindAllCategoriesUseCasePort
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(array $filter): array
    {
        return $this->categoryRepository->findAll($filter);
    }
}

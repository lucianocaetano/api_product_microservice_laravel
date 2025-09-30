<?php

namespace Src\product\application\use_cases;

use Src\product\application\contracts\in\GetByCategorySlugProductsUseCasePort;
use Src\product\application\contracts\out\ProductRepository;

class GetByCategorySlugProductUseCase implements GetByCategorySlugProductsUseCasePort
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}

    public function execute(string $slug): array
    {
        return $this->productRepository->findByCategorySlug($slug);
    }
}

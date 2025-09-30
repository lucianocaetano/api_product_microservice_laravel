<?php

namespace Src\product\application\use_cases;

use Src\product\application\contracts\in\GetAllProductUseCasePort;
use Src\product\application\contracts\out\ProductRepository;

class GetAllProductUseCase implements GetAllProductUseCasePort
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}

    public function execute(array $filter): array
    {
        return $this->productRepository->findAll($filter);
    }
}

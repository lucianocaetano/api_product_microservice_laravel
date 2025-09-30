<?php

namespace Src\product\application\use_cases;

use Src\product\application\contracts\in\GetByIdProductUseCasePort;
use Src\product\application\contracts\out\ProductRepository;
use Src\product\domain\entities\Product;

class GetByIdProductUseCase implements GetByIdProductUseCasePort
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}

    public function execute(string $id): Product
    {
        return $this->productRepository->findById($id);
    }
}

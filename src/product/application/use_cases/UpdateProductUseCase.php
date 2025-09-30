<?php

namespace Src\product\application\use_cases;

use Src\product\application\contracts\in\UpdateProductUseCasePort;
use Src\product\domain\entities\Product;
use Src\product\application\contracts\out\ProductRepository;

class UpdateProductUseCase implements UpdateProductUseCasePort
{
    public function __construct(
        private ProductRepository $repository
    ) {}

    public function execute(Product $product): void
    {
        $this->repository->update($product);
    }
}

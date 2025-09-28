<?php

namespace Src\product\application\use_cases;

use Src\product\application\contracts\in\CreateProductUseCasePort;
use Src\product\domain\entities\Product;
use Src\product\domain\repositories\ProductRepository;

class CreateProductUseCase implements CreateProductUseCasePort
{
    public function __construct(
        private ProductRepository $repository
    ) {}

    public function execute(Product $product): Product
    {
        return $this->repository->save($product);
    }
}

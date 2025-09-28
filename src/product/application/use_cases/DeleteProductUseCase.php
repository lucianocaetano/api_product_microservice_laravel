<?php

namespace Src\product\application\use_cases;

use Src\product\application\contracts\in\DeleteProductUseCasePort;
use Src\product\models\repositories\ProductRepository;

class DeleteProductUseCase implements DeleteProductUseCasePort
{
    public function __construct(
        private ProductRepository $repository
    ) {}

    public function execute(string $id): void
    {
        $this->repository->delete($id);
    }
}

<?php

namespace Src\product\domain\repositories;

use Src\product\domain\entities\Product;

interface ProductRepository
{
    /**
     * @return [
     *   "items" => Product[],
     *   "meta" => array
     * ]
     */
    public function findAll(array $filter): array;

    public function findById(string $id): Product;
    public function save(Product $product): Product;
    public function update(Product $product): Product;
    public function delete(string $id): void;
}

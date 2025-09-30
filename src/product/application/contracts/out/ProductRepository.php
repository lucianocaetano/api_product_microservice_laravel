<?php

namespace Src\product\application\contracts\out;

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
    public function findByCategorySlug(string $id): array;
    public function findById(string $id): Product;
    public function save(Product $product): void;
    public function update(Product $product): void;
    public function delete(string $id): void;
}

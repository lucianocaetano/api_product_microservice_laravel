<?php

namespace Src\category\application\contracts\out;

use Src\category\domain\entities\Category;

interface CategoryRepository
{
    /**
     * @return [
     *   "items" => Category[],
     *   "meta" => array
     * ]
     */
    public function findAll(array $filter): array;
    public function save(Category $category): void;
    public function update(Category $category): void;
    public function delete(string $slug): void;
}

<?php

namespace App\category\infrastructure\repositories;

use Src\category\application\contracts\out\CategoryRepository;
use Src\category\domain\entities\Category;
use Src\category\infrastructure\models\Category as ModelsCategory;

class EloquentCategoryRepository implements CategoryRepository {

    public function findAll(array $filter): array
    {
        $categories = ModelsCategory::paginate();

        return [
            "items" => array_map([$this, "mapCategory"], $categories->items()),
            "meta" => [
                "current_page" => $categories->currentPage(),
                "last_page" => $categories->lastPage(),
                "total" => $categories->total()
            ]
        ];
    }

    public function save(Category $category): void
    {

        ModelsCategory::create([
            "_id" => $category->getId(),
            "slug" => $category->getSlug(),
            "name" => $category->getName(),
            "parent" => $category->getParent(),
        ]);
    }

    public function update(Category $category): void
    {
        $model = ModelsCategory::where("_id", $category->getId())->first();

        $model->update([
            "slug" => $category->getSlug(),
            "name" => $category->getName(),
            "slug" => $category->getSlug(),
            "parent" => $category->getParent(),
        ]);
    }

    public function delete(string $slug): void
    {
        ModelsCategory::where("slug", $slug)->delete();
    }

    private function mapCategory(ModelsCategory $category): Category
    {
        return new Category(
            $category->_id,
            $category->slug,
            $category->name,
            $category->parent
        );
    }
}

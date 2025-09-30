<?php

namespace Src\category\infrastructure\controllers;

use App\Http\Controllers\Controller;
use Src\category\application\use_cases\FindAllCategoriesUseCase;
use Src\category\domain\entities\Category;

class CategoryController extends Controller
{

    public function __construct(
        private FindAllCategoriesUseCase $findAllCategoriesUseCase
    ) {}

    public function index()
    {
        $categories = $this->findAllCategoriesUseCase->execute([]);

        return response()->json([
            "items" => array_map([$this, "mapToArray"], $categories["items"]),
            "meta" => $categories["meta"]
        ]);
    }

    private function mapToArray(Category $category): array {
        return [
            "id" => $category->getId(),
            "slug" => $category->getSlug(),
            "name" => $category->getName(),
            "parent" => $category->getParent(),
        ];
    }
}

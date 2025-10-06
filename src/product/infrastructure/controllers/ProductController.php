<?php

namespace Src\product\infrastructure\controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\product\application\contracts\in\GetAllProductUseCasePort;
use Src\product\application\contracts\in\GetByCategorySlugProductsUseCasePort;
use Src\product\application\contracts\in\GetByIdProductUseCasePort;
use Src\product\domain\entities\Product;

class ProductController extends Controller {

    public function __construct(
        private GetAllProductUseCasePort $getAllProductUseCase,
        private GetByIdProductUseCasePort $getByIdProductUseCase,
        private GetByCategorySlugProductsUseCasePort $getByCategorySlugProductUseCase
    ) {}

    public function index(Request $request) {
        $filter = $request->query();

        $products = $this->getAllProductUseCase->execute($filter);

        return response()->json([
            "items" => array_map([$this, 'mapDomainToArray'], $products['items']),
            "meta" => $products['meta'],
        ]);
    }

    public function getByCategorySlug(string $slug) {
        $products = $this->getByCategorySlugProductUseCase->execute($slug);

        return response()->json([
            "items" => array_map([$this, 'mapDomainToArray'], $products['items']),
            "meta" => $products['meta'],
        ]);
    }

    public function show(string $id) {
        $product = $this->getByIdProductUseCase->execute($id);

        return response()->json(
            $this->mapDomainToArray(
                $product
            )
        );
    }

    public function show_by_slug(string $slug) {
        //TODO: create a use case form find a product by its slug
        $product = $this->getByIdProductUseCase->execute($slug);

        return response()->json(
            $this->mapDomainToArray(
                $product
            )
        );
    }

    private function mapDomainToArray(Product $product) {
        return [
            'id' => $product->getId(),
            'slug' => $product->getSlug(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'quantity' => $product->getQuantity(),
            'price' => $product->getPrice(),
            'currency' => $product->getCurrency(),
            'category_slug' => $product->getCategorySlug()
        ];
    }
}

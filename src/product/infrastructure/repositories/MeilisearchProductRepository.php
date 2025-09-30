<?php

namespace Src\product\infrastructure\repositories;

use Src\product\domain\entities\Product;
use Src\product\application\contracts\out\ProductRepository;
use Src\product\infrastructure\models\Product as ModelsProduct;

class MeilisearchProductRepository implements ProductRepository
{

    /**
     * @return [
     *   "items" => Product[],
     *   "meta" => array
     * ]
     */
    public function findAll(array $filter): array
    {
        $page = $filter['page'] ?? 1;
        $perPage = $filter['perPage'] ?? 15;

        $results = ModelsProduct::search($filter['search'] ?? '')
            ->when(!empty($filter['name']), fn($query) => $query->where('name', $filter['name']))
            ->when(!empty($filter['category_slug']), fn($query) => $query->where('category_slug', $filter['category_slug']))
            ->when(!empty($filter['min_price']), fn($query) => $query->where('price', '>=', $filter['min_price']))
            ->when(!empty($filter['max_price']), fn($query) => $query->where('price', '<=', $filter['max_price']))
            ->paginate($perPage, 'page', $page);

        return [
            'items' => array_map([$this, 'mapProduct'], $results->items()),
            'meta' => [
                'total' => $results->total(),
                'page' => $results->currentPage(),
                'perPage' => $results->perPage(),
            ],
        ];
    }

    public function findByCategorySlug(string $slug): array
    {

        $page = $filter['page'] ?? 1;
        $perPage = $filter['perPage'] ?? 15;

        $results = ModelsProduct::where('category_slug', $slug)
            ->paginate($perPage, 'page', $page);

        return [
            'items' => array_map([$this, 'mapProduct'], $results->items()),
            'meta' => [
                'total' => $results->total(),
                'page' => $results->currentPage(),
                'perPage' => $results->perPage(),
            ],
        ];
    }

    public function findById(string $id): Product
    {
        $data = ModelsProduct::findOrFail($id);

        return $this->mapProduct($data);
    }

    public function save(Product $product): void
    {
        $model = ModelsProduct::updateOrCreate(
            ['_id' => $product->getId()],
            [
                'slug' => $product->getSlug(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'quantity' => $product->getQuantity(),
                'price' => $product->getPrice(),
                'currency' => $product->getCurrency(),
                'category_slug' => $product->getCategorySlug(),
            ]
        );

        $model->searchable();
    }

    public function update(Product $product): void
    {
        $this->save($product);
    }

    public function delete(string $id): void
    {
        $product = ModelsProduct::findOrFail($id);
        $product->unsearchable();
    }

    private function mapProduct(ModelsProduct $product): Product
    {
        return new Product(
            $product->_id,
            $product->slug,
            $product->name,
            $product->description,
            $product->quantity,
            $product->price,
            $product->currency,
            $product->category_slug
        );
    }
}


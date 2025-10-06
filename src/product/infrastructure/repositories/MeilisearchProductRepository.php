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

        $query = ModelsProduct::search($filter['search'] ?? '');

        if (isset($filter['category_slug'])) {
            $query->where('category_slug', $filter['category_slug']);
        }

        if (isset($filter['min_price']) && isset($filter['max_price'])) {
            $query->whereBetween('price', [$filter['min_price'], $filter['max_price']]);
        } elseif (isset($filter['min_price'])) {
            $query->where('price', '>=', $filter['min_price']);
        } elseif (isset($filter['max_price'])) {
            $query->where('price', '<=', $filter['max_price']);
        }

        $results = $query->paginate($perPage, 'page', $page);

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
        try {
            $product = ModelsProduct::findOrFail($id);
            $product->delete();
            $product->unsearchable();
        } catch (\Exception $_) {
            return;
        }
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


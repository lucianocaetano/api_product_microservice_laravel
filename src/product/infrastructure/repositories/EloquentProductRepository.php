<?php

namespace Src\product\infrastructure\repositories;

use MongoDB\Collection;
use MongoDB\BSON\ObjectId;
use Src\product\domain\entities\Product;
use Src\product\domain\repositories\ProductRepository;

class EloquentProductRepository implements ProductRepository
{
    private Collection $collection;

    /**
     * @return [
     *   "items" => Product[],
     *   "meta" => array
     * ]
     */
    public function findAll(array $filter): array
    {
        $product = $this->collection->find($filter);

        return $product->toArray();
    }

    public function findById(string $id): Product
    {
        $product = $this->collection->findOne(['_id' => new ObjectId($id)]);

        return new Product(
            $product['_id']->__toString(),
            $product['slug'],
            $product['name'],
            $product['description'],
            $product['quantity'],
            $product['price'],
            $product['category_id']
        );
    }

    public function save(Product $product): Product
    {

        dd($product);
        $data = $this->collection->insertOne([
            'slug' => $product->getSlug(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'quantity' => $product->getQuantity(),
            'price' => $product->getPrice(),
            'category_id' => $product->getCategoryId()
        ]);

        return new Product(
            $data->getInsertedId(),
            $product->getSlug(),
            $product->getName(),
            $product->getDescription(),
            $product->getQuantity(),
            $product->getPrice(),
            $product->getCategoryId()
        );
    }

    public function update(Product $product): Product
    {
        $data = $this->collection->insertOne([
            'slug' => $product->getSlug(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'quantity' => $product->getQuantity(),
            'price' => $product->getPrice(),
            'category_id' => $product->getCategoryId()
        ]);

        return new Product(
            $data->getInsertedId(),
            $product->getSlug(),
            $product->getName(),
            $product->getDescription(),
            $product->getQuantity(),
            $product->getPrice(),
            $product->getCategoryId()
        );
    }

    public function delete(string $id): void
    {
        $this->collection->deleteOne(['_id' => new ObjectId($id)]);
    }
}

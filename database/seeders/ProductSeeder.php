<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\product\infrastructure\models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::updateOrCreate(
            ['_id' => uniqid()],
            [
                'slug' => "product-1",
                'name' => "Product 1",
                'description' => fake()->paragraph(),
                'quantity' => 200,
                'price' => 200.0,
                'currency' => "$",
                'category_slug' => "category-1"
            ]
        );
    }
}

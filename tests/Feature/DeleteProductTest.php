<?php

namespace Tests\Feature;

use Src\product\infrastructure\models\Product;
use Symfony\Component\Process\Process;
use Tests\KafkaProducer;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    private KafkaProducer $producer;
    private Process $process;

    protected function setUp(): void
    {
        parent::setUp();

        Product::truncate();

        $this->process = new Process(['php', 'artisan', 'kafka:consume']);
        $this->process->start();

        $this->producer = KafkaProducer::getInstance();

        Product::create([
            "id" => "new id",
            "name" => "product name",
            "slug" => "product-name",
            "images" => [],
            "description" => "product description",
            "quantity" => 1,
            "amount" => 1,
            "currency" => "$",
            "category_slug" => "category-name"
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->process->stop();

        Product::truncate();

    }

    public function test_delete_a_product_with_kafka(): void
    {
        $id = "new id";

        $this->producer->produce(
            "product.deleted",
            [
                "id" => $id,
            ]
        );

        sleep(2);

        $product = Product::where("_id", $id)->first();

        $this->assertTrue($product === null);
    }
}

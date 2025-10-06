<?php

namespace Tests\Feature;

use Src\product\infrastructure\models\Product;
use Symfony\Component\Process\Process;
use Tests\KafkaProducer;
use Tests\TestCase;

class CreateProductTest extends TestCase
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
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->process->stop();

        Product::truncate();
    }

    public function test_create_a_product_with_kafka(): void
    {
        $id = "new id";

        $this->producer->produce(
            "product.created",
            [
                "id" => $id,
                "name" => "product name",
                "slug" => "product-name",
                "images" => [],
                "description" => "product description",
                "quantity" => 1,
                "amount" => 1,
                "currency" => "$",
                "category_slug" => "category-name"
            ]
        );

        sleep(2);

        $product = Product::where("_id", $id)->first();

        $this->assertEquals("product name", $product->name);
        $this->assertEquals("product-name", $product->slug);
        $this->assertEquals("product description", $product->description);
        $this->assertEquals(1, $product->quantity);
        $this->assertEquals(1, $product->price);
        $this->assertEquals("$", $product->currency);
        $this->assertEquals("category-name", $product->category_slug);

        $this->producer->produce(
            "product.deleted",
            [
                "id" => $id,
            ]
        );
    }
}

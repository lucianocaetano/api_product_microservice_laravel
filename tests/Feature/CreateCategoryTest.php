<?php

namespace Tests\Feature;

use Src\category\infrastructure\models\Category;
use Symfony\Component\Process\Process;
use Tests\KafkaProducer;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    private KafkaProducer $producer;
    private Process $process;

    protected function setUp(): void
    {
        parent::setUp();

        Category::truncate();

        $this->process = new Process(['php', 'artisan', 'kafka:consume']);
        $this->process->start();

        $this->producer = KafkaProducer::getInstance();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->process->stop();

        Category::truncate();
    }

    public function test_create_a_category_with_kafka(): void
    {
        $id = "new id";

        $this->producer->produce(
            "category.created",
            [
                "id" => $id,
                "name" => "category name",
                "slug" => "category-name",
                "parent" => null
            ]
        );

        sleep(2);

        $category = Category::where("_id", $id)->first();

        $this->assertEquals("category name", $category->name);
        $this->assertEquals("category-name", $category->slug);
        $this->assertEquals(null, $category->parent);

        $this->producer->produce(
            "category.deleted",
            [
                "id" => $category->slug,
            ]
        );
    }
}

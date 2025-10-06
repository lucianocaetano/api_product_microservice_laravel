<?php

namespace Tests\Feature;

use Src\category\infrastructure\models\Category;
use Symfony\Component\Process\Process;
use Tests\KafkaProducer;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
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

         Category::create([
            "_id"    => "new id",
            "name"   => "category name",
            "slug"   => "category-name",
            "parent" => null
        ]);

    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->process->stop();

        Category::truncate();
    }

    public function test_update_a_category_with_kafka(): void
    {
        $id = "new id";

        $this->producer->produce(
            "category.updated",
            [
                "id" => $id,
                "name" => "category name 2",
                "slug" => "category-name-2",
                "parent" => null
            ]
        );

        sleep(2);

        $category = Category::where("_id", $id)->first();

        $this->assertEquals("category name 2", $category->name);
        $this->assertEquals("category-name-2", $category->slug);
        $this->assertEquals(null, $category->parent);

        $this->producer->produce(
            "category.deleted",
            [
                "id" => $category->slug,
            ]
        );
    }
}

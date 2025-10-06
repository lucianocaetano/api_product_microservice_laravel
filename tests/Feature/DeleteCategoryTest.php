<?php

namespace Tests\Feature;

use Src\category\infrastructure\models\Category;
use Symfony\Component\Process\Process;
use Tests\KafkaProducer;
use Tests\TestCase;

class DeleteCategoryTest extends TestCase
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
            "category.deleted",
            [
                "id" => "category-name",
            ]
        );

        sleep(2);

        $category = Category::where("_id", $id)->first();

        $this->assertTrue($category === null);
    }
}

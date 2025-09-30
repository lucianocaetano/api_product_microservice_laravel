<?php

namespace Src\shared\infrastructure\providers;

use Illuminate\Support\ServiceProvider;
use Src\category\infrastructure\events\CreatedCategory;
use Src\category\infrastructure\events\DeletedCategory;
use Src\category\infrastructure\events\UpdatedCategory;

use Src\category\infrastructure\handlers\CreatedCategoryHandler;
use Src\category\infrastructure\handlers\UpdatedCategoryHandler;
use Src\category\infrastructure\handlers\DeletedCategoryHandler;

use Src\product\infrastructure\events\CreatedProduct;
use Src\product\infrastructure\events\DeletedProduct;
use Src\product\infrastructure\events\UpdatedProduct;
use Src\product\infrastructure\handlers\CreatedProductHandler;
use Src\product\infrastructure\handlers\DeletedProductHandler;
use Src\product\infrastructure\handlers\UpdatedProductHandler;

use Src\shared\infrastructure\mediator\Mediator;
use Src\shared\infrastructure\mediator\MediatorEventInterface;

class SharedServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MediatorEventInterface::class, function () {
            $mediator = new Mediator();
            $mediator->register(CreatedProduct::class, CreatedProductHandler::class);
            $mediator->register(UpdatedProduct::class, UpdatedProductHandler::class);
            $mediator->register(DeletedProduct::class, DeletedProductHandler::class);

            $mediator->register(CreatedCategory::class, CreatedCategoryHandler::class);
            $mediator->register(UpdatedCategory::class, UpdatedCategoryHandler::class);
            $mediator->register(DeletedCategory::class, DeletedCategoryHandler::class);

            return $mediator;
        });
    }

    public function boot(): void
    {
        //
    }
}

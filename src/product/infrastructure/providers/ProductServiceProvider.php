<?php

namespace Src\product\infrastructure\providers;

use Illuminate\Support\ServiceProvider;
use Src\product\application\contracts\in\CreateProductUseCasePort;
use Src\product\application\contracts\in\DeleteProductUseCasePort;
use Src\product\application\contracts\in\GetAllProductUseCasePort;
use Src\product\application\contracts\in\GetByCategorySlugProductsUseCasePort;
use Src\product\application\contracts\in\GetByIdProductUseCasePort;
use Src\product\application\contracts\in\UpdateProductUseCasePort;
use Src\product\application\contracts\out\ProductRepository;

use Src\product\application\use_cases\CreateProductUseCase;
use Src\product\application\use_cases\DeleteProductUseCase;
use Src\product\application\use_cases\UpdateProductUseCase;
use Src\product\application\use_cases\GetAllProductUseCase;
use Src\product\application\use_cases\GetByCategorySlugProductUseCase;
use Src\product\application\use_cases\GetByIdProductUseCase;

use Src\product\infrastructure\repositories\MeilisearchProductRepository;

class ProductServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ProductRepository::class,
            MeilisearchProductRepository::class
        );

        $this->app->bind(
            GetAllProductUseCasePort::class,
            GetAllProductUseCase::class
        );

        $this->app->bind(
            GetByIdProductUseCasePort::class,
            GetByIdProductUseCase::class
        );

        $this->app->bind(
            GetByCategorySlugProductsUseCasePort::class,
            GetByCategorySlugProductUseCase::class
        );

        $this->app->bind(
            CreateProductUseCasePort::class,
            CreateProductUseCase::class
        );

        $this->app->bind(
            UpdateProductUseCasePort::class,
            UpdateProductUseCase::class
        );

        $this->app->bind(
            DeleteProductUseCasePort::class,
            DeleteProductUseCase::class
        );
    }

    public function boot()
    {
        //
    }
}

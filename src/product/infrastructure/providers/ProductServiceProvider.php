<?php

namespace Src\product\infrastructure\providers;

use Illuminate\Support\ServiceProvider;
use Src\product\application\contracts\in\CreateProductUseCasePort;
use Src\product\application\contracts\in\DeleteProductUseCasePort;
use Src\product\application\contracts\in\UpdateProductUseCasePort;
use Src\product\application\use_cases\CreateProductUseCase;
use Src\product\application\use_cases\DeleteProductUseCase;
use Src\product\application\use_cases\UpdateProductUseCase;
use Src\product\infrastructure\repositories\EloquentProductRepository;
use Src\product\domain\repositories\ProductRepository;

class ProductServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ProductRepository::class,
            EloquentProductRepository::class
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

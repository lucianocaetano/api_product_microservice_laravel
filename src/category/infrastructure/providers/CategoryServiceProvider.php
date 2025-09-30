<?php

namespace Src\category\infrastructure\providers;

use Illuminate\Support\ServiceProvider;

use Src\category\application\contracts\in\CreateCategoryUseCasePort;
use Src\category\application\contracts\in\DeleteCategoryUseCasePort;
use Src\category\application\contracts\in\UpdateCategoryUseCasePort;
use Src\category\application\use_cases\CreateCategoryUseCase;
use Src\category\application\use_cases\DeleteCategoryUseCase;
use Src\category\application\use_cases\UpdateCategoryUseCase;

class CategoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CreateCategoryUseCasePort::class, CreateCategoryUseCase::class);
        $this->app->bind(UpdateCategoryUseCasePort::class, UpdateCategoryUseCase::class);
        $this->app->bind(DeleteCategoryUseCasePort::class, DeleteCategoryUseCase::class);
    }

    public function boot(): void
    {
        //
    }
}

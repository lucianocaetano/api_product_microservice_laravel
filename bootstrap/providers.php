<?php

use Src\category\infrastructure\providers\CategoryServiceProvider;
use Src\product\infrastructure\providers\ProductServiceProvider;
use Src\shared\infrastructure\providers\SharedServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    SharedServiceProvider::class,
    ProductServiceProvider::class,
    CategoryServiceProvider::class
];

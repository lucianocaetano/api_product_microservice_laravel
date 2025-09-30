<?php

use Illuminate\Support\Facades\Route;

Route::prefix("/product")->group(base_path('src/product/infrastructure/routes/api.php'));

Route::prefix('/category')->group(base_path('src/category/infrastructure/routes/api.php'));

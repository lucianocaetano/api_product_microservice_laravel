<?php

use Illuminate\Support\Facades\Route;
use Src\category\infrastructure\controllers\CategoryController;

Route::get('/categories', [CategoryController::class, "index"]);

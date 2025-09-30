<?php

use Illuminate\Support\Facades\Route;
use Src\product\infrastructure\controllers\ProductController;

Route::get('', [ProductController::class, 'index']);
Route::get('/{id}', [ProductController::class, 'show']);

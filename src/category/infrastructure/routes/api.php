<?php

use Illuminate\Support\Facades\Route;
use Src\category\infrastructure\controllers\CategoryController;

Route::get('', [CategoryController::class, "index"]);

Route::prefix("Product")->group(base_path('src//Product/infrastructure/routes/api.php'));Route::prefix("product")->group(base_path('src//product/infrastructure/routes/api.php'));
Route::prefix('shared')->group(base_path('src/shared/infrastructure/routes/api.php'));

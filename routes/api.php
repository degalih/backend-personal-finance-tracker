<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\FinancesController;
use App\Http\Controllers\HelloController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/* Test API Controller */
Route::get('/hello-world', [HelloController::class, 'index']);

/* Categories */
Route::get('/categories', [CategoriesController::class, 'index']);

/* Expenses */
Route::prefix('/finances')->group(function () {
    Route::get('', [FinancesController::class, 'index']);
    Route::post('/import', [FinancesController::class, 'importRecord']);
});


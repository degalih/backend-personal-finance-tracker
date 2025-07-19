<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ExpensesController;
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
Route::prefix('/expenses')->group(function () {
    Route::post('/import', [ExpensesController::class, 'importExpenses']);
});


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{id}', [CategoryController::class, 'catpage']);
Route::get('/subcategory/{id}', [CategoryController::class, 'subcatpage']);
Route::get('/product/{id}', [ProductController::class, 'index']);



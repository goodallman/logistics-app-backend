<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehousesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Product API
Route::get('/product', [ProductController::class, 'getAllProducts'])->middleware(['auth:sanctum']);
Route::post('/product', [ProductController::class, 'addProduct'])->middleware(['auth:sanctum']);

Route::get('/product/{id}', [ProductController::class, 'getProductById'])->where('id', '[0-9]+')->middleware(['auth:sanctum']);
Route::put('/product/{id}', [ProductController::class, 'updateProduct'])->where('id', '[0-9]+')->middleware(['auth:sanctum']);
Route::delete('/product/{id}', [ProductController::class, 'deleteProduct'])->where('id', '[0-9]+')->middleware(['auth:sanctum']);

//Katalog API
Route::get('/catalog', [ProductController::class, 'catalogGet'])->middleware(['auth:sanctum']);
Route::post('/catalog', [ProductController::class, 'catalogAddApi'])->middleware(['auth:sanctum']);
Route::delete('/catalog/{id}', [ProductController::class, 'catalogDeleteAssoc'])->where('id', '[0-9]+')->middleware(['auth:sanctum']);

//User API
Route::post('/user', [UserController::class, 'addUser']);

Route::post('/user/auth', [UserController::class, 'authUser']);
Route::get('/user/auth', [UserController::class, 'checkLogin']);


//Supplier API
Route::get('/supplier', [SupplierController::class, 'getAllSuppliers'])->middleware(['auth:sanctum']);
Route::post('/supplier', [SupplierController::class, 'addSupplier'])->middleware(['auth:sanctum']);

Route::get('/supplier/{id}', [SupplierController::class, 'getSupplierById'])->where('id', '[0-9]+')->middleware(['auth:sanctum']);
Route::delete('/supplier/{id}', [SupplierController::class, 'removeSupplier'])->where('id', '[0-9]+')->middleware(['auth:sanctum']);

//Warehouse API
Route::get('/warehouse', [WarehousesController::class, 'getAllWarehouses'])->middleware(['auth:sanctum']);
Route::post('/warehouse', [WarehousesController::class, 'addWarehouse'])->middleware(['auth:sanctum']);

Route::get('/warehouse/{id}', [WarehousesController::class, 'getWaregousesById'])->where('id', '[0-9]+')->middleware(['auth:sanctum']);
Route::delete('/warehouse/{id}', [WarehousesController::class, 'removeWarehouse'])->where('id', '[0-9]+')->middleware(['auth:sanctum']);

Route::get('/warehouse/{id}/products', [WarehousesController::class, 'getWarehouseProducts'])->where('id', '[0-9]+')->middleware(['auth:sanctum']);
Route::post('/warehouse/{id}/products', [WarehousesController::class, 'addProductToWarehouse'])->where('id', '[0-9]+')->middleware(['auth:sanctum']);
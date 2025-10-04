<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products',[ProductController::class,'index'])->name('product.index');

Route::get('/create-product',[ProductController::class,'create'])->name('product.create');
Route::post('/store-product',[ProductController::class,'store'])->name('product.store');
Route::get('/show-product/{id}',[ProductController::class,'show'])->name('product.show');
Route::get('/edit-product/{id}',[ProductController::class,'edit'])->name('product.edit');

Route::post('/update-product/{id}',[ProductController::class,'update'])->name('product.update');

Route::delete('/destroy-product/{id}',[ProductController::class,'destroy'])->name('product.destroy');
Route::get('/show-trashed-product/{id}',[ProductController::class,'showTrashed'])->name('trashed.show');

Route::get('/deleted-product',[ProductController::class,'trashedProducts'])->name('product.trashed');
Route::put('restore-product/{id}',[ProductController::class,'restoreProduct'])->name('product.restore');
Route::delete('delete-product/{id}',[ProductController::class,'destroyProduct'])->name('product.delete');

Route::get('/users',[UserController::class,'index'])->name('user.index');





Route::get('/create-user',[UserController::class,'create'])->name('user.create');
Route::post('/store-user',[UserController::class,'store'])->name('user.store');
Route::get('/show-user/{id}',[UserController::class,'show'])->name('user.show');
Route::get('/edit-user/{id}',[UserController::class,'edit'])->name('user.edit');

Route::post('/update-user/{id}',[UserController::class,'update'])->name('user.update');

Route::delete('/destroy-user/{id}',[UserController::class,'destroy'])->name('user.destroy');
Route::get('/show-trashed-user/{id}',[UserController::class,'showTrashed'])->name('trashed.show');

Route::get('/deleted-users',[UserController::class,'trashedUses'])->name('user.trashed');
Route::put('restore-user/{id}',[UserController::class,'restoreUser'])->name('user.restore');
Route::delete('delete-user/{id}',[UserController::class,'destroyUser'])->name('user.delete');


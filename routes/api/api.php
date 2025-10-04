<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
});
// ->middleware('auth:sanctum');

// Routes API pour les utilisateurs
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']); // Liste des users
    Route::get('/{id}', [UserController::class, 'show']); // Voir un user
    Route::post('/', [UserController::class, 'store']); // Créer un user
    Route::put('/{id}', [UserController::class, 'update']); // Modifier un user
    Route::delete('/{id}', [UserController::class, 'destroy']); // Supprimer un user
});

// Routes API pour les produits
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']); // Liste des produits
    Route::get('/{id}', [ProductController::class, 'show']); // Voir un produit
    Route::post('/', [ProductController::class, 'store']); // Créer un produit
    Route::put('/{id}', [ProductController::class, 'update']); // Modifier un produit
    Route::delete('/{id}', [ProductController::class, 'destroy']); // Supprimer un produit
});
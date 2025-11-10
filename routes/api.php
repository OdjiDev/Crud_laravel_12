<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\api\ProduitController;


// routes/api.php


// Cette ligne génère automatiquement les 5 routes CRUD (GET, POST, GET/{id}, PUT/PATCH/{id}, DELETE/{id})

Route::apiResource('api/users',UserController::class);

// Routes pour les produits (avec apiResource)
Route::apiResource('api/produits', ProduitController::class);
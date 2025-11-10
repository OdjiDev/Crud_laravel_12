<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ProduitController;


// routes/api.php

// Déclare les routes API sous le préfixe `/api` (géré par RouteServiceProvider)
// Utilisez `Route::apiResource('users', ...)` — la route complète deviendra `/api/users`.
Route::apiResource('users', UserController::class);

// Routes pour les produits (avec apiResource)
Route::apiResource('produits', ProduitController::class);
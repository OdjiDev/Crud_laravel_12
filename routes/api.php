<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController as ApiUserController;

// routes/api.php

// Déclare les routes API sous le préfixe `/api` (géré par RouteServiceProvider)
// Utilisez `Route::apiResource('users', ...)` — la route complète deviendra `/api/users`.
Route::apiResource('users', ApiUserController::class);

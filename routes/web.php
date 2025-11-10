<?php

use App\Http\Controllers\ProductController;
//use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
// use App\Http\routes\api.php;

Route::get('/', function () {
    return view('welcome');
});








// Les routes API ne doivent pas être incluses manuellement ici.
// Le fichier `routes/api.php` est chargé automatiquement par
// RouteServiceProvider et est associé au middleware `api`.
// include "api.php"; // removed to avoid CSRF/session middleware on API routes

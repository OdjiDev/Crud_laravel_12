<?php

use App\Http\Controllers\ProductController;
//use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
// use App\Http\routes\api.php;

Route::get('/', function () {
    return view('welcome');
});








//on inclu les routes api ici

include "api.php";

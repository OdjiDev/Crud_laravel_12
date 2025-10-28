<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;


// routes/api.php


// Cette ligne génère automatiquement les 5 routes CRUD (GET, POST, GET/{id}, PUT/PATCH/{id}, DELETE/{id})

Route::apiResource('api/users',UserController::class);

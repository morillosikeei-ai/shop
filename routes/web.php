<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/',
    [ProductController::class,'index']);

Route::post('/import',
    [ProductController::class,'import']);

Route::get('/export',
    [ProductController::class,'export']);
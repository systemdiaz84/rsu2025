<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BrandController;
use Illuminate\Support\Facades\Route;

Route::resource('/', AdminController::class)->names('admin');
Route::resource('brands', BrandController::class)->names('admin.brands');

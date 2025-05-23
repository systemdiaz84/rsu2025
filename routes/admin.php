<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\BrandmodelController;
use App\Http\Controllers\admin\VehicleController;
use App\Http\Controllers\admin\VehicleimagesController;
use App\Http\Controllers\admin\VehicletypesController;
use Illuminate\Support\Facades\Route;

Route::resource('/', AdminController::class)->names('admin');
Route::resource('brands', BrandController::class)->names('admin.brands');
Route::resource('models', BrandmodelController::class)->names('admin.models');
Route::resource('vehicletypes', VehicletypesController::class)->names('admin.vehicletypes');
Route::resource('vehicles', VehicleController::class)->names('admin.vehicles');
Route::resource('vehicleimages', VehicleimagesController::class)->names('admin.vehicleimages');
Route::get('modelsbybrand/{id}', [BrandmodelController::class, 'modelsbybrand'])->name('admin.modelsbybrand');
Route::get('imageprofile/{id}/{vehicle_id}', [VehicleimagesController::class, 'profile'])->name('admin.imageprofile');
Route::get('vehicles/{id}/images', [VehicleController::class, 'showImages'])->name('vehicles.images');


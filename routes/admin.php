<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EditController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FileController;

    // Zwe Zar Ni
Route::apiResource('categories', CategoryController::class);
Route::apiResource('contents', ContentController::class);
Route::apiResource('sliders', SliderController::class);
Route::post('files', [FileController::class, 'store']);
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\ApplicationFormController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ServiceController;

    // Zwe Zar Ni
Route::apiResource('categories', CategoryController::class);
Route::apiResource('contents', ContentController::class);
Route::apiResource('sliders', SliderController::class);
Route::apiResource('services' , ServiceController::class);
Route::apiResource('jobs' , JobController::class);
Route::apiResource('application-forms' , ApplicationFormController::class);
Route::post('files', [FileController::class, 'store']);
Route::get('files/{file}', [FileController::class, 'show']);
Route::get('files' , [FileController::class , 'index']);

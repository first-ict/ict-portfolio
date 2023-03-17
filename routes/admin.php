<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EditController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CategoryController;



    // Zwe Zar Ni
    Route::apiResource('categories', CategoryController::class);


    // Zwe Zar Ni
Route::apiResource('categories', CategoryController::class);





// Api Resource
// Eg. Route::apiResource('categories', CategoryController::class);


// get - categories - index()
// post - categories - store()
// get - categories/{category} - show()
// put/patch - catgories/{category} - update()
// delete - categories/{category} - delete

<?php

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Frontend\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/get-sliders',[HomeController::class, 'getSliders']);
Route::get('/get-contents',[HomeController::class, 'getContents']);
Route::get('/get-content/{slug}',[HomeController::class, 'getContent']);
Route::get('/get-service/{id}',[HomeController::class, 'getService']);
Route::get('/get-all-contents',[HomeController::class, 'getAllContents']);
Route::get('/get-all-services',[HomeController::class, 'getAllServices']);
Route::get('/get-all-categories' , [HomeController::class , 'getCategories']);
Route::get('/get-contents-by-category/{id}' , [HomeController::class , 'getContentsByCategory']);

Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);
Route::get('/get-sliders',[HomeController::class,'getSliders']);
Route::post('/contact-us',[ContactController::class,'store']);
Route::get('/contact-us/{contact}',[ContactController::class,'show']);
Route::get('/contact-us',[ContactController::class,'index']);
Route::delete('/contact-us/{contact}',[ContactController::class,'delete']);

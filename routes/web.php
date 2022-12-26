<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get("/file-upload", function(){
    return view('file');
});
Route::post('/file', function(Request $request){
    // testing34.jpg
    // 'testing'.rand(0, 88). '.'.$request->file('image')->clientExtension()
    $name = $request->file('image')->storeAs('public/public_testing', 'helloworld'.rand(0, 88). '.'.$request->file('image')->clientExtension());
    dd($name);
});

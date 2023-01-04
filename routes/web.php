<?php
use App\Models\Slider;
use App\Models\User;
use App\Http\Controllers\Admin\SliderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
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
Route::get('/register',function(){
    // $user = new User();
    // $user->email = "naruto@gmail.com";
    // $user->name = "naruto";
    // $user->password = Hash::make('narut0');
    // $user->save();
    // $token = $user->createToken('First-ict')->plainTextToken;
    // return ['User'=> $user,'Token'=> $token];
});
Route::get('/make-roles', function(){
    $user = User::first();
    $user->assignRole('admin');
    return $user->createToken('first-ict')->plainTextToken;
    // Role::create(['name' => 'admin']);
    // Role::create(['name' => 'client']);
    // Role::create(['name' => 'customer']);
});
Route::get('/id', function(){
    return session()->getId();
});




Route::post('/slider', function (Request $request) {
    $filename = time()."_".$request->file('image')->getClientOriginalName();

});






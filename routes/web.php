<?php
use App\Models\File;
use App\Models\User;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Frontend\HomeController;

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
    $slider = Slider::all();
    $data =  $slider->pluck('image_id')->toArray();
    $file = File::whereNotIn('id', $data)->get();
   $photos =  $file->pluck('file')->toArray();
   File::whereNotIn('id', $data)->delete();
   Storage::delete($photos);
    return response()->json([
        'data' => 'oki',
    ]);
});
Route::get('/register',function(){
    // $user = new User();
    // $user->email = "admin@gmail.com";
    // $user->name = "admin";
    // $user->password = Hash::make('admin');
    // $user->save();
    // $token = $user->createToken('First-ict')->plainTextToken;
    // return ['User'=> $user,'Token'=> $token];
});
Route::get('/make-roles', function(){
    // $user = User::first();
    // $user->assignRole('admin');
    // return $user->createToken('first-ict')->plainTextToken;
    // Role::create(['name' => 'admin']);
    // Role::create(['name' => 'client']);
    // Role::create(['name' => 'customer']);
});
Route::get('/id', function(){
    return session()->getId();
});




// Route::get('/register', function() {
//     $user = new user();
//     $user->email = 'cr7@gmail.com';
//     $user->name = 'C R 7';
//     $user->password = Hash::make('internet');
//     $user->save();
//     $token = $user->createToken('second-ict')->plainTextToken;
//     return ['user' => $user, 'token' => $token];
// });
Route::post('/slider', function (Request $request) {
    $filename = time()."_".$request->file('image')->getClientOriginalName();
});




#1|eS9Al9T6JVkf2Mpm7qU5R5mXuH3G3oD5AMJXx5in
#2|yyoSaMRy3dzkOEju29TRB9Rqim8HNOxVUtwU9k4p
#3|1q7Y0FtfCesaq5l9ELUQGdqb16qzpzlXEaiEXo95
#4|csnj3Z08zG7GEkoOXeS1fULF3txRsT6f2lr35N0V

#7|LjEmCTwxtyxNcMXZZrbkuPXQmSy5nvMZSMEnlTF6   admin



<?php
use App\Models\Slider;
use App\Http\Controllers\Admin\SliderController;
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
Route::get('/id', function(){
    return session()->getId();
});

Route::post('/slider', function (Request $request) {
    $filename = time()."_".$request->file('image')->getClientOriginalName();

});

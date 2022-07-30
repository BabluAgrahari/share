<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\UserController as User;

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

// Route::get('/', function () {
//     return view('admin.dashboard');
// });

// Route::resource('product',Product::class);
Route::get('/',[user::class,'index']);
Route::get('create',[user::class,'create']);
Route::POST('store',[user::class,'store']);
Route::POST('login',[user::class,'show']);
Route::get('dashboard',[user::class,'dashboard']);
Route::get('logout',[user::class,'logout']);
Route::get('home',[user::class,'home']);
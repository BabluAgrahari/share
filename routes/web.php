<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\LoginController as User;
use App\http\Controllers\admin\ClientController as Client;
use App\http\Controllers\admin\ContactPersonController as ContactPerson;

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

Route::get('/',         [user::class, 'index']);
Route::get('register',  [user::class, 'register']);
Route::POST('store',    [user::class, 'store']);
Route::POST('login',    [user::class, 'show']);
Route::get('dashboard', [user::class, 'dashboard']);
Route::get('logout',    [user::class, 'logout']);
Route::get('home',      [user::class, 'home']);

Route::resource('client',Client::class);
Route::get('delete/{id}',      [Client::class, 'delete']);

Route::resource('contact',ContactPerson::class);
Route::get('delete2/{id}',      [ContactPerson::class, 'delete']);
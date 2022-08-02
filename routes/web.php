<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\LoginController as Login;
use App\http\Controllers\admin\ClientController as Client;
use App\http\Controllers\admin\UserController as User;
use App\http\Controllers\admin\ContactPersonController as ContactPerson;
use App\http\Controllers\Admin\CompanyController as Company;
use App\http\Controllers\Admin\TransferAgentsController as TransferAgents;
use App\http\Controllers\Admin\CourtController as Court;

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

Route::get('/',         [User::class, 'index']);
Route::get('create',  [User::class, 'create']);
Route::POST('store',    [User::class, 'store']);
Route::POST('login',    [User::class, 'show']);
Route::get('dashboard', [User::class, 'dashboard']);
Route::get('logout',    [User::class, 'logout']);
Route::get('home',      [User::class, 'home']);
Route::get('list',      [User::class, 'list']);
Route::post('update',   [User::class, 'update']);
Route::get('edit/{id}',      [User::class, 'edit']);
Route::get('delete6',      [User::class, 'delete']);

Route::resource('client', Client::class);
Route::get('delete/{id}',      [Client::class, 'delete']);
Route::get('client/find-agent/{id}', [Client::class, 'findClient']);

Route::resource('contact', ContactPerson::class);
Route::get('delete2/{id}',      [ContactPerson::class, 'delete']);

Route::resource('company', Company::class);
Route::get('delete3/{id}',      [Company::class, 'delete']);

Route::resource('transfer-agent', TransferAgents::class);
Route::get('delete4/{id}',      [TransferAgents::class, 'delete']);

Route::resource('court', Court::class);
Route::get('delete5/{id}',      [Court::class, 'delete']);

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::get('/optimize', function () {
    Artisan::call('optimize');
    return "Cache/Route is cleared";
});

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\LoginController as Login;
use App\Http\Controllers\admin\ClientController as Client;
use App\Http\Controllers\admin\UserController as User;
use App\Http\Controllers\admin\ContactPersonController as ContactPerson;
use App\Http\Controllers\Admin\CompanyController as Company;
use App\Http\Controllers\Admin\TransferAgentsController as TransferAgents;
use App\Http\Controllers\Admin\CourtController as Court;

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
Route::get('/',         [Login::class, 'index']);
Route::POST('login',    [Login::class, 'show']);
Route::get('dashboard', [Login::class, 'dashboard']);
Route::get('logout',    [Login::class, 'logout']);
Route::get('home',      [User::class, 'home']);

Route::group(['middleware' => 'auth'], function () {
    Route::resource('client',   Client::class);
    Route::resource('user',   User::class);
    Route::get('client/find-agent/{id}', [Client::class, 'findClient']);
    Route::post('assign-user',  [Client::class, 'assignUser']);
    Route::get('assign-user',   [Client::class, 'assignUserModal']);
    Route::get('find-company',  [Client::class, 'findCompany']);
    Route::post('follow-up',    [Client::class, 'followUp']);
    Route::get('find-contact-person', [Client::class, 'findContactPerson']);
    Route::post('save-cp',      [Client::class, 'saveCP']);
    Route::resource('contact', ContactPerson::class);
    Route::resource('company', Company::class);
    Route::resource('transfer-agent', TransferAgents::class);
    Route::resource('court', Court::class);
   
});

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::get('/optimize', function () {
    Artisan::call('optimize');
    return "Cache/Route is cleared";
});

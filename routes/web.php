<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\LoginController as Login;
use App\Http\Controllers\Admin\ClientController as Client;
use App\Http\Controllers\Admin\UserController as User;
use App\Http\Controllers\Admin\ContactPersonController as ContactPerson;
use App\Http\Controllers\Admin\CompanyController as Company;
use App\Http\Controllers\Admin\TransferAgentsController as TransferAgents;
use App\Http\Controllers\Admin\CourtController as Court;
use App\Http\Controllers\Admin\FollowUpController as FollowUp;
use App\Http\Controllers\Admin\DashboardController as Dashboard;

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
Route::group(['middleware' => 'guest'], function () {
    Route::get('/',         [Login::class, 'index']);
    Route::POST('login',    [Login::class, 'show']);
});

Route::group(['middleware' => 'auth'], function () {

    Route::resource('user',   User::class);

    Route::resource('contact-person',   ContactPerson::class);

    Route::post('user-status', [User::class, 'status']);

    Route::resource('client',   Client::class);

    Route::post('assign-user',  [Client::class, 'assignUser']);
    Route::get('assign-user',   [Client::class, 'assignUserModal']);
    Route::post('client-status',  [Client::class, 'status']);
    Route::get('client/find-agent/{id}', [Client::class, 'findClient']);
    Route::get('client-export', [Client::class, 'export']);

    Route::get('follow-up-list/{status}', [FollowUp::class, 'index']);
    Route::resource('follow-up-list', FollowUp::class);
    Route::get('find-company',        [FollowUp::class, 'findCompany']);
    Route::post('follow-up',          [FollowUp::class, 'followUp']);
    Route::post('save-cp',            [FollowUp::class, 'saveCP']);
    Route::get('find-contact-person', [FollowUp::class, 'findContactPerson']);
    Route::get('revert-follow-up/{status}/{id}',    [FollowUp::class, 'revertFollowUp']);
    Route::get('follow-up-export', [FollowUp::class, 'export']);

    Route::resource('company', Company::class);
    Route::post('company-status', [Company::class, 'status']);

    Route::resource('transfer-agent', TransferAgents::class);
    Route::post('transfer-agent-status', [TransferAgents::class, 'status']);

    Route::resource('court', Court::class);
    Route::post('court-status', [Court::class, 'status']);

    Route::get('dashboard', [Dashboard::class, 'index']);
    Route::get('logout',    [Login::class, 'logout']);
});

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::get('/optimize', function () {
    Artisan::call('optimize');
    return "Cache/Route is cleared";
});

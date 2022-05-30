<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PartnerServiceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

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

Route::get('test', [DashboardController::class, 'test']);
Route::get('get-user-by-partner/{id}', [UserController::class, 'getUserByPartner']);
Route::post('order/create', [TransactionController::class, 'create'])->middleware('auth:sanctum');

Route::group([
    'prefix'    => 'auth'
], function(){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('partner-register', [AuthController::class, 'partnerRegister']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::post('auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group([
    'prefix'        => 'partner',
    'middleware'    => 'auth:sanctum'
], function(){
    Route::post('create', [PartnerController::class, 'create']);
    Route::get('get-partner/{id}', [PartnerController::class, 'getPartner']);
    Route::get('get-partner-by-user/{id}', [PartnerController::class, 'getPartnerByUser']);
    Route::get('get-partners-by-service/{id}', [PartnerController::class, 'getPartnersByService']);
    Route::get('get-partner/{id1}/service/{id2}', [PartnerController::class, 'getPartnerAndService']);
});

Route::group([
    'prefix'        => 'partner-service',
    'middleware'    => 'auth:sanctum'
], function(){
    Route::get('create', [PartnerServiceController::class, 'create']);
    Route::post('store', [PartnerServiceController::class, 'store']);
});

Route::group([
    'prefix'        => 'dashboard',
    'middleware'    => 'auth:sanctum'
], function(){
    Route::get('search/{q}', [DashboardController::class, 'search']);
});


Route::group([
    'prefix'        => 'user',
    'middleware'    => 'auth:sanctum'
], function(){
    Route::get('edit/{id}', [UserController::class, 'edit']);
    Route::get('get-user-role/{id}', [UserController::class, 'getUserRole']);
});


Route::group([
    'prefix' => 'transaction',
    'middleware'    => 'auth:sanctum'
], function(){
    Route::post('create', [TransactionController::class, 'create']);
    Route::post('accept', [TransactionController::class, 'accept']);
    Route::post('reject', [TransactionController::class, 'reject']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

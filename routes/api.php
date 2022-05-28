<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PartnerServiceController;

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

Route::group([
    'prefix'    => 'auth'
], function(){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('partner-register', [AuthController::class, 'partnerRegister']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group([
    'prefix'        => 'partner',
    'middleware'    => 'auth:sanctum'
], function(){
    Route::post('create', [PartnerController::class, 'create']);
    Route::get('get-partner/{id}', [PartnerController::class, 'getPartner']);
    Route::get('get-partners-by-service/{id}', [PartnerController::class, 'getPartnersByService']);
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('auth/register', [UserController::class, 'register']);
Route::post('auth/login',[UserController::class, 'login']);
// Admin auth
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('user-info',[UserController::class, 'getUserInfo']);
    Route::post('logout',[UserController::class, 'logout']);
});

Route::group(['prefix' => 'LoginCustomer'], function () {
    Route::post('register', [CustomerController::class, 'register']);
    Route::post('login', [CustomerController::class, 'login']);
    Route::post('get', [CustomerController::class, 'customer']);
});

// Customer auth
Route::group(['middleware' => ['jwt.Authcustomer']], function () {
    Route::get('customer-info', [CustomerController::class, 'customer']);
});

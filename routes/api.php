<?php

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RestaurantController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Les routes d'authentification de user
Route::post('/user/register', [UserController::class, 'userRegister'] );
Route::post('/user/login', [UserController::class, 'userLogin'] );
Route::group([
    ['middleware' => 'auth:api'],
    'prefix' => 'auth'
], function ($router) {

    Route::post('/user/logout', [UserController::class, 'userLogout']);
    Route::post('/user/me', [UserController::class, 'userMe']);
    
});

// Les routes d'authentification de restaurant
Route::post('/restaurant/register', [RestaurantController::class, 'restaurantRegister'] );
Route::post('/restaurant/login', [RestaurantController::class, 'restaurantLogin'] );
Route::group([
    ['middleware' => 'auth:restaurant-api'],
    'prefix' => 'auth'
], function ($router) {

    Route::post('/restaurant/logout', [RestaurantController::class, 'restaurantLogout']);
    Route::post('/restaurant/me', [RestaurantController::class, 'restaurantMe']);
    
});
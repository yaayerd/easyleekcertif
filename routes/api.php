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
Route::post('/user/modify/profile/{user}', [UserController::class, 'userModifyProfile'] );
Route::post('/user/logout', [UserController::class, 'userLogout']);
Route::post('/user/me', [UserController::class, 'userMe']);

Route::group([
    ['middleware' => 'auth:user-api'],
    'prefix' => 'auth'
], function ($router) {

    
});

// Les routes d'authentification de restaurant
Route::post('/restaurant/register', [UserController::class, 'restaurantRegister'] );
Route::post('/restaurant/login', [UserController::class, 'restaurantLogin'] );
Route::post('/restaurant/modify/profile/{restaurant}', [UserController::class, 'restautantModifyProfile'] );
Route::post('/restaurant/logout', [UserController::class, 'restaurantLogout']);
Route::post('/restaurant/me', [UserController::class, 'restaurantMe']);

Route::group([
    ['middleware' => 'auth:restaurant-api'],
    'prefix' => 'auth'
], function ($router) {

    
});
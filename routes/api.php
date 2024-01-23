<?php

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\Other\CategorieController;
use App\Http\Controllers\Api\Other\CatégorieController;
use App\Http\Controllers\Api\Other\MenuController;

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

// --------------------  Les routes liées à Catégorie 

Route::get('/categorie/list', [CategorieController::class, 'index'] );
Route::post('/categorie/store', [CategorieController::class, 'store'] );
Route::put('/categorie/update/{id}', [CategorieController::class, 'update']);
Route::get('/categorie/show/{id}', [CategorieController::class, 'show']);
Route::delete('/categorie/delete/{id}', [CategorieController::class, 'destroy']);


// --------------------  Les routes liées au Menu 

Route::get('/menu/list', [MenuController::class, 'index'] );
Route::post('/menu/store', [MenuController::class, 'store'] );
Route::put('/menu/update/{id}', [MenuController::class, 'update']);
Route::get('/menu/show/{id}', [MenuController::class, 'show']);
Route::delete('/menu/delete/{id}', [MenuController::class, 'destroy']);



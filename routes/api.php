<?php

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\Other\CategorieController;
use App\Http\Controllers\Api\Other\CatégorieController;
use App\Http\Controllers\Api\Other\CommandeController;
use App\Http\Controllers\Api\Other\MenuController;
use App\Http\Controllers\Api\Other\PlatController;
use App\Models\Commande;

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


// --------------------  Les routes liées au Plat 

Route::get('/plat/list', [PlatController::class, 'index'] );
Route::post('/plat/store', [PlatController::class, 'store'] );
Route::put('/plat/update/{id}', [PlatController::class, 'update']);
Route::patch('/plat/archiver/{id}', [PlatController::class, 'archiver']);
Route::patch('/plat/desarchiver/{id}', [PlatController::class, 'desarchiver']);
Route::get('/plat/show/{id}', [PlatController::class, 'show']);
Route::delete('/plat/delete/{id}', [PlatController::class, 'destroy']);


// --------------------  Les routes liées à Commande pour le User

Route::get('/commande/list', [CommandeController::class, 'index'] );
Route::post('/commande/store', [CommandeController::class, 'store'] );
Route::put('/commande/update/{commande}', [CommandeController::class, 'updateCommande']);
Route::get('/commande/show/{id}', [CommandeController::class, 'show']);
Route::delete('/commande/annuler/{id}', [CommandeController::class, 'annulerCommande']);


// --------------------  Les routes liées à Commande pour le restaurant

Route::put('/commande/refuser/{id}', [CommandeController::class, 'refuserCommande']);
Route::put('/commande/accepter/{id}', [CommandeController::class, 'accepterCommande']);



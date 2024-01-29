<?php

use App\Http\Controllers\Api\Other\AvisController;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Other\CategorieController;
use App\Http\Controllers\Api\Other\CommandeController;
use App\Http\Controllers\Api\Other\MenuController;
use App\Http\Controllers\Api\Other\PlatController;
use App\Http\Controllers\Api\Other\RoleController;
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

Route::group([
    ['middleware' => 'auth:user-api'],
    'prefix' => 'auth'
], function ($router) {
});



// **********************Les routes libres à tous users ***************************

Route::post('/restaurant/register', [UserController::class, 'restaurantRegister']);
Route::post('/restaurant/login', [UserController::class, 'restaurantLogin']);
Route::post('/user/register', [UserController::class, 'userRegister']);
Route::post('/user/login', [UserController::class, 'userLogin']);
// -----------------------------Libres ---------------------
Route::get('/categorie/list', [CategorieController::class, 'index']);
Route::get('/menu/list', [MenuController::class, 'index']);
Route::get('/avis/list', [AvisController::class, 'index']);
Route::get('/plat/list', [PlatController::class, 'index']);






// Les routes de l' AdminSystem**************************************************

Route::group(['prefix' => 'auth', 'middleware' => ['auth:user-api', 'adminSystem']], function () {

    // --------------------  Les routes liées à Catégorie 

    Route::post('/categorie/store', [CategorieController::class, 'store']);
    Route::put('/categorie/update/{id}', [CategorieController::class, 'update']);
    Route::get('/categorie/show/{id}', [CategorieController::class, 'show']);
    Route::delete('/categorie/delete/{id}', [CategorieController::class, 'destroy']);

    // --------------------  Les routes liées aux Rôles 

    Route::get('/role/list', [RoleController::class, 'index']);
    Route::post('/role/store', [RoleController::class, 'store']);
    Route::put('/role/update/{id}', [RoleController::class, 'update']);
    Route::get('/role/show/{id}', [RoleController::class, 'show']);
    Route::delete('/role/delete/{id}', [RoleController::class, 'destroy']);
});


// Les routes  pour le restaurant**************************************

Route::group(['prefix' => 'auth', 'middleware' => ['auth:user-api', 'restaurant']], function () {

    // ------------------Route pour le restaurant sur son profil du restaurant 

    Route::post('/restaurant/modify/profile/{restaurant}', [UserController::class, 'restautantModifyProfile']);
    Route::post('/restaurant/logout', [UserController::class, 'restaurantLogout']);
    Route::post('/restaurant/me', [UserController::class, 'restaurantMe']);

    // --------------------  Les routes liées au Menu 

    Route::post('/menu/store', [MenuController::class, 'store']);
    Route::put('/menu/update/{id}', [MenuController::class, 'update']);
    Route::get('/menu/show/{id}', [MenuController::class, 'show']);
    Route::delete('/menu/delete/{id}', [MenuController::class, 'destroy']);

    // --------------------  Les routes liées au Plat 

    Route::post('/plat/store', [PlatController::class, 'store']);
    Route::put('/plat/update/{id}', [PlatController::class, 'update']);
    Route::patch('/plat/archiver/{id}', [PlatController::class, 'archiver']);
    Route::patch('/plat/desarchiver/{id}', [PlatController::class, 'desarchiver']);
    Route::get('/plat/show/{id}', [PlatController::class, 'show']);
    Route::delete('/plat/delete/{id}', [PlatController::class, 'destroy']);

    // --------------------  Les routes liées à Commande pour le restaurant
    
    Route::get('/commande/list', [CommandeController::class, 'index']);
    Route::put('/commande/refuser/{id}', [CommandeController::class, 'refuserCommande']);
    Route::put('/commande/accepter/{id}', [CommandeController::class, 'accepterCommande']);
});



// Les routes du Client ********************************************

Route::group(['prefix' => 'auth', 'middleware' => ['auth:user-api', 'adminSystem']], function () {

    // Les routes d'authentification de user

    Route::post('/user/modify/profile/{user}', [UserController::class, 'userModifyProfile']);
    Route::post('/user/logout', [UserController::class, 'userLogout']);
    Route::post('/user/me', [UserController::class, 'userMe']);

    // --------------------  Les routes liées à Commande pour le User

    Route::get('/commande/list', [CommandeController::class, 'index']);
    Route::post('/commande/store', [CommandeController::class, 'store']);
    Route::put('/commande/update/{commande}', [CommandeController::class, 'updateCommande']);
    Route::get('/commande/show/{id}', [CommandeController::class, 'show']);
    Route::delete('/commande/annuler/{id}', [CommandeController::class, 'annulerCommande']);

    // --------------------  Les routes liées aux Avis 

    Route::post('/avis/store', [AvisController::class, 'store']);
    Route::put('/avis/update/{id}', [AvisController::class, 'update']);
    Route::get('/avis/show/{id}', [AvisController::class, 'show']);
    Route::delete('/avis/delete/{id}', [AvisController::class, 'destroy']);
});

<?php

use App\Models\Commande;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\Other\AvisController;
use App\Http\Controllers\Api\Other\MenuController;
use App\Http\Controllers\Api\Other\PlatController;
use App\Http\Controllers\Api\Other\RoleController;
use App\Http\Controllers\Api\Other\LivreurController;
use App\Http\Controllers\Api\Other\CommandeController;
use App\Http\Controllers\Api\Other\CategorieController;
use App\Http\Controllers\Api\Other\LivraisonController;

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

Route::post('/user/register', [UserController::class, 'userRegister']);

Route::post('/restaurant/login', [UserController::class, 'restaurantLogin']);
Route::post('/user/login', [UserController::class, 'userLogin']);

Route::post('/message/to/admin', [MessageController::class, 'messageToAdmin']);

Route::get('/categorie/list', [CategorieController::class, 'index']);

Route::get('/restaurant/list/', [UserController::class, 'getAllRestaurant']);
Route::get('/list/restaurant/{categorie_id}', [UserController::class, 'getRestaurantByCategorie']);
Route::get('/restaurant/details/{id}', [UserController::class, 'getRestaurantDetails']);

Route::get('/menu/list', [MenuController::class, 'index']);
Route::get('/byrestaurant/menu/list/{restaurant_id}', [MenuController::class, 'listMenubyRestaurant']);

Route::get('/plat/list/', [PlatController::class, 'index']);
Route::get('/plat/list/{menu_id}', [PlatController::class, 'getPlatbyMenu']);
Route::get('/plat/show/{id}', [PlatController::class, 'show']);
Route::get('/plat/list/byrestaurant/{restaurant_id}', [PlatController::class, 'indexPlatByRestaurant']);

Route::get('/avis/list', [AvisController::class, 'index']);
Route::get('/avis/show/{id}', [AvisController::class, 'show']);



// Les routes de l' AdminSystem**************************************************

Route::group(['prefix' => 'auth', 'middleware' => ['auth:user-api', 'adminSystem']], function () {

    //-------------------------Gestion Comptes Utilisateurs--------------------

    // ------------------------------Client ----------------------
    Route::get('/client/list/all', [UserController::class, 'listAllClient']);
    Route::get('/client/details/{id}', [UserController::class, 'voirUserDetails']);
    Route::post('/client/compte/block/{id}', [UserController::class, 'blockUser']);
    Route::post('/client/compte/unblock/{id}', [UserController::class, 'unblockUser']);
    Route::get('/client/list/blocked', [UserController::class, 'listClientBlocked']);
    Route::get('/client/list/unblocked', [UserController::class, 'listClientUnblocked']);

    // ------------------------------Restaurant  ----------------------
    Route::post('/restaurant/register', [UserController::class, 'restaurantRegister']);
    Route::get('/restaurant/details/{id}', [UserController::class, 'voirRestaurantDetails']);
    Route::post('/restaurant/compte/block/{id}', [UserController::class, 'blockRestaurant']);
    Route::post('/restaurant/compte/unblock/{id}', [UserController::class, 'unblockRestaurant']);
    Route::get('/restaurant/list/all', [UserController::class, 'listAllRestaurant']);
    Route::get('/restaurant/list/unblocked', [UserController::class, 'listRestaurantUnblocked']);
    Route::get('/restaurant/list/blocked', [UserController::class, 'listRestaurantBlocked']);

    Route::get('/message/list', [MessageController::class, 'ListMessage']);
    
    // --------------------  Les routes liées à Catégorie 
    Route::post('/categorie/store', [CategorieController::class, 'store']);
    Route::get('/categorie/list', [CategorieController::class, 'index']);
    Route::put('/categorie/update/{id}', [CategorieController::class, 'update']);
    Route::get('/categorie/show/{id}', [CategorieController::class, 'show']);
   
    // --------------------  Les routes liées aux Rôles 

    Route::post('/role/store', [RoleController::class, 'store']);
    Route::get('/role/list', [RoleController::class, 'index']);
    Route::put('/role/update/{id}', [RoleController::class, 'update']);
    Route::get('/role/show/{id}', [RoleController::class, 'show']);
    
});


// Les routes  pour le restaurant**************************************

Route::group(['prefix' => 'auth', 'middleware' => ['auth:user-api', 'restaurant']], function () {

    // ------------------ Route pour le restaurant sur son profil du restaurant  ok

    Route::get('/restaurant/me', [UserController::class, 'restaurantMe']);
    Route::post('/restaurant/modify/profile/{restaurant}', [UserController::class, 'restautantModifyProfile']);
    Route::post('/restaurant/logout', [UserController::class, 'restaurantLogout']);

    // --------------------  Les routes liées au Menu 

    Route::post('/menu/store', [MenuController::class, 'store']);
    Route::get('/all/menu/list', [MenuController::class, 'index']);
    Route::get('/restaurant/menu/list', [MenuController::class, 'getMenuOfRestaurant']);
    Route::put('/menu/update/{id}', [MenuController::class, 'update']);
    Route::get('/menu/show/{id}', [MenuController::class, 'show']);
    Route::delete('/menu/delete/{id}', [MenuController::class, 'destroy']);

    // --------------------  Les routes liées au Plat 

    Route::post('/plat/store', [PlatController::class, 'store']);
    Route::get('/plat/list/restaurant', [PlatController::class, 'indexPlatForRestaurant']);
    Route::get('/plat/list/restaurant/{menu}', [PlatController::class, 'indexPlatbyMenu']);
    Route::get('/plat/show/{id}', [PlatController::class, 'show']);
    Route::put('/plat/update/{id}', [PlatController::class, 'update']);
    Route::patch('/plat/archiver/{id}', [PlatController::class, 'archiver']);
    Route::patch('/plat/desarchiver/{id}', [PlatController::class, 'desarchiver']);
    Route::delete('/plat/delete/{id}', [PlatController::class, 'destroy']);

    // --------------------  Les routes liées à Commande pour le restaurant

    Route::get('/commande/list/restaurant', [CommandeController::class, 'indexCommandeForRestaurant']);
    Route::get('/commande/plat/list/{plat_id}', [CommandeController::class, 'getCommandebyPlat']);
    Route::put('/commande/refuser/{id}', [CommandeController::class, 'refuserCommande']);
    Route::put('/commande/accepter/{id}', [CommandeController::class, 'accepterCommande']);
    Route::put('/commande/terminer/{id}', [CommandeController::class, 'terminerCommande']);
    Route::get('/restaurant/commande/plat/list', [CommandeController::class, 'indexCommandeForRestaurant']);
    Route::get('/restaurant/commande/show/{id}', [CommandeController::class, 'showCommandeForRestaurant']);
    
});



// Les routes du Client ********************************************

Route::group(['prefix' => 'auth', 'middleware' => ['auth:user-api', 'client']], function () {

    // Les routes d'authentification de user

    Route::post('/user/modify/profile/{user}', [UserController::class, 'userModifyProfile']);
    Route::post('/user/logout', [UserController::class, 'userLogout']);
    Route::get('/user/me', [UserController::class, 'userMe']);

    // --------------------  Les routes liées à Commande pour le User

    Route::post('/commande/store', [CommandeController::class, 'store']);
    Route::get('/commande/list', [CommandeController::class, 'index']);
    Route::put('/commande/update/{commande}', [CommandeController::class, 'updateCommande']);
    Route::get('/commande/show/{id}', [CommandeController::class, 'showCommandeForClient']);
    Route::delete('/commande/annuler/{id}', [CommandeController::class, 'annulerCommande']);

    // --------------------  Les routes liées aux Avis 
    
    Route::post('/client/avis/avisStore/', [AvisController::class, 'avisStore']);
    Route::get('/client/avis/list', [AvisController::class, 'index']);
    Route::put('/client/avis/update/{id}', [AvisController::class, 'update']);
    Route::get('/client/avis/show/{id}', [AvisController::class, 'show']);
    Route::delete('/client/avis/delete/{id}', [AvisController::class, 'destroy']);

});


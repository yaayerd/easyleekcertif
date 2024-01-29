<?php

namespace App\Http\Controllers\Api\Other;

use Exception;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Menu\CreateMenuRequest;
use App\Http\Requests\Api\Menu\UpdateMenuRequest;
use App\Models\Restaurant;
use App\Models\User;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json([
                'status' => true,
                'statut code' => 200,
                'message' => "Voici le Menu du restaurant. ",
                'menu'  => Menu::all(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 401,
                "message" => "Vous n'êtes pas connecté, donc vous n'avez pas à accès à cette ressource.."
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateMenuRequest $request, Menu $menu)
    {
        $this->authorize('store', $menu);

        try {
            $restaurant = $request->user();
            if ($restaurant && $restaurant->role_id == 2) {
                // $restaurant = User::find($request->_id);
                $lerestaurant_id = $request->user()->id;
                $lemenu = new Menu();
                $lemenu->user_id = $lerestaurant_id; //restaurant->id;
                $lemenu->titre = $request->titre;
                // dd($lemenu);
                $lemenu->save();

                return response()->json([
                    'status' => true,
                    'statut code' => 200,
                    'message' => "Le menu enrégistré avec succès",
                    'menu'  => $lemenu,
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "status_code" => 401,
                    "message" => "Vous n'avez pas le rôle requis pour accéder à cette ressource."
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue lors de l'insertion.",
                "error"   => $e
            ]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $lemenu = Menu::find($id);
            // dd($lemenu);
            if ($lemenu === null) {
                return response()->json([
                    'status' => false,
                    'statut_code' => 404,
                    'statut_message' => 'Ce Menu n\'existe pas',
                ]);
            } else {

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'statut_message' => 'Voici le menu du restaurant',
                    'menu' => $lemenu,
                ]);
            }
        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "statut_code" => 401,
                "message" => "Vous n'êtes pas connecté, donc vous n'avez pas à accès à cette ressource."
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $this->authorize('update', $menu);

        try {
            // $lemenu = Menu::find($id);
            // dd($lemenu);

            if ($menu === null) {
                return response()->json([
                    "status" => false,
                    "statut_code" => 404,
                    "message" => "Ce menu n'existe pas.",
                ]);
            } else {

                $menu->titre = $request->titre;

                $menu->update();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'statut_message' => 'Le titre du menu a été modifié avec succès',
                    'menu' => $menu,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 401,
                'message' => "Vous n'êtes pas connecté, donc vous n'avez pas à accès à cette ressource."
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $this->authorize('destroy', $menu);
        
        try {
            // $lemenu = Menu::find($id);

            if ($menu === null) {
                return response()->json([
                    'status' => false,
                    'statut_code' => 404,
                    'statut_message' => 'Ce menu n\'existe pas',
                ]);
            } else {

                $menu->delete();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'statut_message' => 'Ce Menu a été supprimé avec succès',
                    'menu' => $menu,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 401,
                'message' => "Vous n'êtes pas connecté, donc vous n'avez pas à accès à cette ressource."
            ]);
        }
    }
}

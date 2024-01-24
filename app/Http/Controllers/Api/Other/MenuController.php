<?php

namespace App\Http\Controllers\Api\Other;

use Exception;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Menu\CreateMenuRequest;
use App\Http\Requests\Api\Menu\UpdateMenuRequest;

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
                'data'  => Menu::all(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 401,
                "message" => "Vous n'êtes pas autorisé à accéder à cette ressource."
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
    public function store(CreateMenuRequest $request)
    {
        try {
            $lemenu = new Menu();
            $lemenu->titre = $request->titre;
            $lemenu->save();

            return response()->json([
                'status' => true,
                'statut code' => 200,
                'message' => "Le menu enrégistré avec succès",
                'data'  => $lemenu,
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 401,
                "message" => "Vous n'êtes pas autorisé à accéder à cette ressource."

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
                    'data' => $lemenu,
                ]);
            }
        } catch (Exception $e) {

            return response()->json([
                "status" => false,
                "statut_code" => 401,
                "message" => "Vous n'êtes pas autorisé à accéder à cette ressource."
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
    public function update(UpdateMenuRequest $request, $id)
    {
        try {
            $lemenu = Menu::find($id);
            // dd($lemenu);

            if ($lemenu === null) {
                return response()->json([
                    "status" => false,
                    "statut_code" => 404,
                    "message" => "Ce menu n'existe pas.",
                ]);
            } else {

                $lemenu->titre = $request->titre;

                $lemenu->update();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'statut_message' => 'Le titre du menu a été modifié avec succès',
                    'data' => $lemenu,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 401,
                'message' => "Vous n'êtes pas autorisé à accéder à cette ressource."
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lemenu = Menu::find($id);

        if ($lemenu === null) {
            return response()->json([
                'status' => false,
                'statut_code' => 404,
                'statut_message' => 'Ce menu n\'existe pas',
            ]);
        } else {

            $lemenu->delete();

            return response()->json([
                'status' => true,
                'statut_code' => 200,
                'statut_message' => 'Ce Menu a été supprimé avec succès',
                'data' => $lemenu,
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\Api\Other;

use Exception;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Categorie\CreateCategorieRequest;
use App\Http\Requests\Api\Categorie\UpdateCategorieRequest;

class CategorieController extends Controller
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
                'message' => "Voici la liste des catégories. ",
                'data'  => Categorie::all(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e->getMessage()
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
    public function store(CreateCategorieRequest $request, Categorie $categorie)
    {
        
        try { 
            $this->authorize('store', $categorie);
            $user = $request->user();
            if ($user && $user->role_id == 1) {
            $categorie = new Categorie();
            $categorie->type = $request->type;
            $categorie->save();

            return response()->json([
                'status' => true,
                'statut code' => 200,
                'message' => "Catégorie enrégistrée avec succès",
                'data'  => $categorie,
            ]);
            } 
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue lors de l'insertion.",
                "error"   => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $categorie = Categorie::find($id);
            // dd($categorie);
            return response()->json([
                'status' => true,
                'statut code' => 200,
                'message' => "Ceci est la catégorie",
                'data'  => $categorie,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 404,
                'message' => "Cette categorie n'existe pas."
            ]);
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e->getMessage()
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
    public function update(UpdateCategorieRequest $request, $id)
    {
        
        try {
            $categorie = Categorie::find($id);
            if ($categorie === null) {
                return response()->json([
                    "status" => false,
                    "statut_code" => 404,
                    "message" => "Cette categorie n'existe pas.",
                ]);
            } else {
                $this->authorize('update', $categorie);
            // dd($request);
            $categorie->type = $request->type;
            $categorie->update();
            return response()->json([
                'status' => true,
                'statut_code' => 200,
                'statut_message' => 'Le type de categorie a été modifié avec succès',
                'data' => $categorie,
            ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $categorie = Categorie::find($id);
            
            if ($categorie === null) {
                return response()->json([
                    'status' => false,
                    'statut_code' => 404,
                    'statut_message' => 'Ce type de categorie n\'existe pas',
                ]);
            } else {
                $this->authorize('store', $categorie);
                
                $categorie->delete();
                
                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'statut_message' => 'Ce type de categorie a été supprimé avec succès',
                    'data' => $categorie,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e->getMessage()
            ]);
        }
    }
}


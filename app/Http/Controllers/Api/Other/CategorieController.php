<?php

namespace App\Http\Controllers\Api\Other;

use Exception;
use App\Models\Categorie;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Catch_;
use App\Http\Controllers\Controller;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = Categorie::all();
            return response()->json([
                'status' => true,
                'statut code' => 200,
                'message' => "Ceci est la liste des catégories",
                'data'  => $categories,
            ]);
        } catch (Exception $e) {
            response()->json($e);
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
    public function store(Request $request)
    {
        $categorie = new Categorie();
        $categorie->type = $request->type;
        $categorie->save();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categorie = Categorie::findOrFail($id);
        // dd($categorie);
        return response()->json([
            'status' => true,
            'statut code' => 200,
            'message' => "Ceci est la catégorie",
            'data'  => $categorie,
        ]);
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
    public function update(Request $request, Categorie $categorie)
    {
        // $categorie= Categorie::findOrFail($id);
        $categorie->type = $request->type;
        $categorie->update();
        // return 'updated';
        // $categorie->save();
        return response()->json([
            'status' => true,
            'statut_code' => 200,
            'statut_message' => 'Le type de categorie a été modifié avec succès',
            'data' => $categorie,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categorie = Categorie::find($id);

        if ($categorie === null) {
            return response()->json([
                'status' => false,
                'statut_code' => 404,
                'statut_message' => 'Ce type de categorie n\'existe pas',
            ]);
        } else {

            $categorie->delete();

            return response()->json([
                'status' => true,
                'statut_code' => 200,
                'statut_message' => 'Ce type de categorie a été supprimé avec succès',
                'data' => $categorie,
            ]);
        }
    }
}

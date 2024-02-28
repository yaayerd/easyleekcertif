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
            ],  200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e->getMessage()
            ],  500);
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
                $categorie->image = $request->image;

                // if ($request->file('image')) {
                //     $file = $request->file('image');
                //     $filename = date('YmdHi') . $file->getClientOriginalName();
                //     $file->move(public_path('images'), $filename);
                //     $categorie['image'] = $filename;
                // }
                // dd($categorie);

                $categorie->save();

                return response()->json([
                    'status' => true,
                    'statut code' => 201,
                    'message' => "Catégorie enrégistrée  avec succès",
                    'data'  => $categorie,
                ],  201);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue lors de l'insertion.",
                "error"   => $e->getMessage()
            ],  500);
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
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 404,
                'message' => "Cette categorie n'existe pas."
            ],  404);
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e->getMessage()
            ],   500);
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
                ],  404);
            } else {
                $this->authorize('update', $categorie);
                // dd($request);
                $categorie->type = $request->type;
                $categorie->image = $request->image;
                // if ($request->file('image')) {
                //     $file = $request->file('image');
                //     $filename = date('YmdHi') . $file->getClientOriginalName();
                //     $file->move(public_path('images'), $filename);
                //     $categorie['image'] = $filename;
                // }
                $categorie->update();
                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'statut_message' => 'Le type de categorie a été modifié avec succès',
                    'data' => $categorie,
                ],   200);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue lors de la modification de la catégorie.",
                "error"   => $e->getMessage()
            ],   500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($id)
    // {
    //     try {
    //         $categorie = Categorie::find($id);

    //         if ($categorie === null) {
    //             return response()->json([
    //                 'status' => false,
    //                 'statut_code' => 404,
    //                 'statut_message' => 'Ce type de categorie n\'existe pas',
    //             ],   404);
    //         } else {
    //             $this->authorize('store', $categorie);

    //             $categorie->delete();

    //             return response()->json([
    //                 'status' => true,
    //                 'statut_code' => 200,
    //                 'statut_message' => 'Ce type de categorie a été supprimé avec succès',
    //                 'data' => $categorie,
    //             ],    200);
    //         }
    //     } catch (Exception $e) {
    //         return response()->json([
    //             "status" => false,
    //             "status_code" => 500,
    //             "message" => "Une erreur est survenue.",
    //             "error"   => $e->getMessage()
    //         ],    500);
    //     }
    // }
}

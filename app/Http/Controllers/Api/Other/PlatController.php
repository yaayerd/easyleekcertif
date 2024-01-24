<?php

namespace App\Http\Controllers\Api\Other;

use Exception;
use App\Models\Plat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Plat\CreatePlatRequest;
use App\Http\Requests\Api\Plat\UpdatePlatRequest;
use App\Http\Requests\Api\Plat\ArchiverPlatRequest;

class PlatController extends Controller
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
                'message' => "Voici les plats du restaurant. ",
                'data'  => Plat::all(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 401,
                "message" => "Vous n'êtes pas autorisé à accéder à ces ressources."
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
    public function store(Request $request)
    {
        try {
            $plat = new Plat();

            $plat->libelle = $request->libelle;
            $plat->prix = $request->prix;
            $plat->descriptif = $request->descriptif;
            $plat->menu_id = $request->menu_id;
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);
                $plat['image'] = $filename;
            }

            // dd($plat);
            
            $plat->save();
            
            // dd($plat); 
            return response()->json([
                'status' => true,
                'statut code' => 200,
                'message' => "Le plat enrégistré avec succès",
                'data'  => $plat,
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
            $plat = Plat::find($id);
            // dd($plat);
            // dd($plat);
            if ($plat === null) {
                return response()->json([
                    'status' => false,
                    'statut_code' => 404,
                    'statut_message' => 'Ce plat n\'existe pas',
                ]);
            } else {

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'statut_message' => 'Voici le plat du restaurant',
                    'data' => $plat,
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
    public function archiver(Request $request, string $id)
    {
        try {
    
            $plat = Plat::find($id);
    
            if ($plat === null) {
                return response()->json([
                    "status" => false,
                    "statut_code" => 404,
                    "message" => "Ce plat n'existe pas dans le menu.",
                ]);
            } else { 
                if ($plat->is_archived === 1) {
                    return response()->json([
                        "status" => true,
                        "statut_code" => 200,
                        "message" => "Ce plat est déjà archivé, il n'est plus disponible dans le menu.",
                    ]);
                } 
                else {
                    $plat->is_archived = $request->is_archived;
                    
                    $plat->update(['is_archived' => true]);
    
                    return response()->json([
                        'status' => true,
                        'statut_code' => 200,
                        'statut_message' => 'Le plat est archivé avec succès',
                        'data' => $plat,
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 401,
                'message' => "Vous n'êtes pas autorisé à accéder à cette ressource."
            ]);
        }
    }
    
    public function desarchiver(Request $request, string $id)
    {
        try {
    
            $plat = Plat::find($id);
    
            if ($plat === null) {
                return response()->json([
                    "status" => false,
                    "statut_code" => 404,
                    "message" => "Ce plat n'existe pas dans le menu.",
                ]);
            } else { 
                if ($plat->is_archived === 0) {
                    return response()->json([
                        "status" => true,
                        "statut_code" => 200,
                        "message" => "Ce plat est déjà désarchivé, il est donc disponible dans le menu.",
                    ]);
                } 
                else {
                    $plat->is_archived = $request->is_archived;
                    
                    $plat->update(['is_archived' => false]);
    
                    return response()->json([
                        'status' => true,
                        'statut_code' => 200,
                        'statut_message' => 'Le plat est désarchivé avec succès, retrouvez le dans votre menu.',
                        'data' => $plat,
                    ]);
                }
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
     * Update the specified resource in storage.
     */
    public function update(UpdatePlatRequest $request, $id)
    {
        try {

            $plat = Plat::find($id);

            // dd($plat);
            
            // $plat->save();

            if ($plat === null) {
                return response()->json([
                    "status" => false,
                    "statut_code" => 404,
                    "message" => "Ce plat n'existe pas.",
                ]);
            } else {

               
            $plat->libelle = $request->libelle;
            $plat->prix = $request->prix;
            $plat->descriptif = $request->descriptif;
            $plat->menu_id = $request->menu_id;
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);
                $plat['image'] = $filename;
            }

                $plat->update();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'statut_message' => 'Le titre du plat a été modifié avec succès',
                    'data' => $plat,
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
        $plat = Plat::find($id);

        if ($plat === null) {
            return response()->json([
                'status' => false,
                'statut_code' => 404,
                'statut_message' => 'Ce plat n\'existe pas',
            ]);
        } else {

            $plat->delete();

            return response()->json([
                'status' => true,
                'statut_code' => 200,
                'statut_message' => 'Ce plat a été supprimé avec succès',
                'data' => $plat,
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\Api\Other;

use Exception;
use App\Models\Plat;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $user = auth()->guard('user-api')->user();

            if ($request->plat_id === null) {
                return response()->json([
                    "status" => false,
                    "statut_code" => 400,
                    "message" => "plat_id est requis."
                ]);
            }

            $plat = Plat::find($request->plat_id);

            if ($plat === null) {
                return response()->json([
                    "status" => false,
                    "statut_code" => 404,
                    "message" => "Le plat n'existe pas."
                ]);
            }

            if ($user) {
                $commandes = Commande::where('user_id', $user->id)->where('plat_id', $plat->id)->get();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'message' => "Voici les commandes de ce plat passées par l'utilisateur connecté.",
                    'data'  => $commandes,
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "statut_code" => 401,
                    "message" => "Vous n'êtes pas connecté, donc vous n'avez pas accès à cette ressource."
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 500,
                "message" => "Une erreur est survenue."
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
            $commande = new Commande();


            $user = auth()->guard('user-api')->user();
            $plat = Plat::find($request->plat_id);
            // dd($plat);

            if ($plat && $user) {
                $commande->user_id = $user->id;
                $commande->plat_id = $plat->id;
                $commande->nombrePlats = $request->nombrePlats;
                $commande->prixCommande = $request->nombrePlats * $plat->prix;
                $commande->numeroCommande = uniqid();
                $commande->lieuLivraison = $request->lieuLivraison;
                // dd($commande);

                $commande->save();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'message' => "Votre commande à été enregistrée avec succès",
                    'data' => $commande
                ], 201);
            }
            // else {
            //     return response()->json([
            //         'status' => false,
            //         'statut_code' => 500, 
            //         'error'=>"Une erreur est survenue lors de l'ajout de la commande, veuillez vérifier vos informations."
            //     ]);
            // }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 401,
                "message" => "Vous n'êtes pas connecté, donc vous n'avez pas à accès à cette ressource."
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Api\Other;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Avis\CreateAvisRequest;
use App\Http\Requests\Api\Avis\UpdateAvisRequest;
use App\Models\Avis;
use App\Models\Commande;
use Exception;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            if ($request->commande_id === null) {
                return response()->json([
                    "status" => false,
                    "statut_code" => 400,
                    "message" => "commande_id est requis."
                ]);
            }
            // $commandes = Commande::where('commande_id', '=', $user->user_id)->get();
            $commande = Commande::find($request->commande_id);
            // dd($commande);

            if ($commande === null) {
                return response()->json([
                    "status" => false,
                    "statut_code" => 404,
                    "message" => "La commande n'existe pas."
                ]);
            }

            if ($user) {
                $lesavis = Avis::where('commande_id', $commande->id)->get();
                // dd($lesavis);
                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'message' => "Voici les avis de cette commande.",
                    'avisClient'  => $lesavis,
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
                "message" => "Une erreur est survenue.",
                "erreur" => $e
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
    public function store(CreateAvisRequest $request)
    {
        try {
            $user = $request->user();
            $avis = new Avis();
            $commande = Commande::find($request->commande_id);
            // dd($commande);

            if ($commande && $user) {
                $avis->commande_id = $commande->id;
                $avis->nomPlatCommande = $commande->nomPlat;
                $avis->note = $request->note;
                $avis->commentaire = $request->commentaire;

                // dd($avis);

                $avis->save();

                return response()->json([
                    'status' => true,
                    'statut_code' => 201,
                    'message' => "Votre avis à été enregistrée avec succès",
                    'avisClient' => $avis
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "statut_code" => 401,
                    "message" => "Vous n'êtes pas connecté, donc vous n'avez pas à accès à cette ressource."
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 500,
                'message' => "Une erreur est survenue lors de l'ajout de la commande, veuillez vérifier vos informations.",
                'error' => $e
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        try {
            $user = $request->user();

            $avis = Avis::find($id);
            if ($avis === null) {
                return response()->json([
                    'status' => false,
                    'statut_code' => 404,
                    'statut_message' => 'Cette commande n\'existe pas',
                ]);
            }
            if ($user) {
                $avis = Avis::where('id', $avis->id)->first();
                // dd($avis);

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'message' => "Voici les détails de l'avis que vous avez fait pour cette commande.",
                    'avis'  => $avis,
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
                "message" => "Une erreur est survenue.",
                "error"   => $e
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
    public function update(UpdateAvisRequest $request, $id)
    {
        try {
            $user = $request->user();
            $avis = Avis::find($id);
            // $avis = Avis::where('id', $avis->commande_id)->get(); 
            // dd($avis);

            if ($avis === null) {
                return response()->json([
                    "status" => false,
                    "statut_code" => 404,
                    "message" => "Cette commande n'existe pas.",
                ]);
            }

            if ($user && $avis) {
                $avis = Avis::where('id', $avis->id)->first();

                $avis->note = $request->note;
                $avis->commentaire = $request->commentaire;

                // dd($avis);
                $avis->update();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'message' => "Votre avis à été modifiée avec succès",
                    'avisClient' => $avis
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "statut_code" => 401,
                    "message" => "Vous n'êtes pas connecté, donc vous n'avez pas à accès à cette ressource."
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 500,
                'message' => "Une erreur est survenue lors de l'ajout de la commande, veuillez vérifier vos informations.",
                'error' => $e
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $user = $request->user();
            $avis = Avis::find($id);

            //    dd($avis);

            if ($avis === null) {
                return response()->json([
                    'status' => false,
                    'statut_code' => 404,
                    'statut_message' => 'Cet avis n\'existe pas',
                ]);
            }
            //    if ($user && $user->role == 'admin') {
            if ($user && $avis) {

                $avis->delete();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'statut_message' => 'Cet avis a été supprimé avec succès',
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

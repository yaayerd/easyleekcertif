<?php

namespace App\Http\Controllers\Api\Other;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Avis\CreateAvisRequest;
use App\Http\Requests\Api\Avis\UpdateAvisRequest;
use App\Models\Avis;
use App\Models\Commande;
use Exception;
use Illuminate\Console\Command;
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
                ],  400);
            }
            // $commandes = Commande::where('commande_id', '=', $user->user_id)->get();
            $commande = Commande::find($request->commande_id);
            // dd($commande);

            if ($commande === null) {
                return response()->json([
                    "status" => false,
                    "statut_code" => 404,
                    "message" => "La commande n'existe pas, donc pas d'avis."
                ],  404);
            }

            if ($user) {
                $lesavis = Avis::where('commande_id', $commande->id)->get();
                // dd($lesavis);
                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'message' => "Voici les avis de cette commande.",
                    'avisClient'  => $lesavis,
                ],  200);
            } 
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 500,
                "message" => "Une erreur est survenue.",
                "erreur" => $e->getMessage()
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
    public function avisStore(CreateAvisRequest $request, Avis $avis)
    {
        
        try {
            $user = $request->user();

            $commande = $request->commande_id;

            $commande = Commande::where('id' , $request->commande_id)->first();
        // $commande = Commande::where('user_id', $user->id)->where('id', $id)->first();

            // dd($commande);
            
            $this->authorize('avisStore', $avis);
            
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
                ],  201);
            } 
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 500,
                'message' => "Une erreur est survenue lors de l'ajout de cet avis, veuillez vérifier vos informations.",
                'error' => $e->getMessage()
            ],  500);
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
                    'statut_message' => 'Cette avis n\'existe pas',
                ],  404);
            }
            if ($user) {
                $avis = Avis::where('id', $avis->id)->first();
                // dd($avis);

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'message' => "Voici les détails de l'avis que vous avez fait pour cette commande.",
                    'avis'  => $avis,
                ],  200);
            } 
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e->getMessage()
            ],  500);
        }
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
                    "message" => "Cette avis n'existe pas.",
                ],  404);
            }
            
            if ($user && $avis) {
                // $this->authorize('update', $avis);

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
                ], 200);
            } 
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 500,
                'message' => "Une erreur est survenue lors de l'ajout de la commande, veuillez vérifier vos informations.",
                'error' => $e->getMessage()
            ],500);
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
                ], 404);
            }
                if ($user && $avis) {

                // $this->authorize('destroy', $avis);

                $avis->delete();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'statut_message' => 'Cet avis a été supprimé avec succès',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 500,
                'message' => "Une erreur est survenue.",
                'error' => $e->getMessage()
            ],500);
        }
    }

    
}

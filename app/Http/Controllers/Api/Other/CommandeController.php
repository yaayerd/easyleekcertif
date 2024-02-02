<?php

namespace App\Http\Controllers\Api\Other;

use Exception;
use App\Models\Plat;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Commande\CreateCommandeRequest;
use App\Http\Requests\Api\Commande\UpdateCommandeRequest;
use Illuminate\Console\Command;

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
                    "message" => "Ce plat est introuvable."
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
                $commandes = Commande::where('user_id', $user->id)->get(); // ->where('plat_id', $plat->id)
                // dd($plat);
                dd($commandes);
                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'message' => "Voici les commandes de ce plat passées par l'utilisateur connecté.",
                    'data'  => $commandes,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 500,
                "message" => "Une erreur est survenue.",
                "erreur" => $e->getMessage()
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


    public function store(CreateCommandeRequest $request, Commande $commande)
    {
        try {
            $user = auth()->guard('user-api')->user();

            $commande = new Commande();

            $this->authorize('store', $commande);

            $plat = Plat::find($request->plat_id);

            if ($plat && $user) {
                $commande->user_id = $user->id;
                $commande->plat_id = $plat->id;
                $commande->nomPlat = $plat->libelle;
                $commande->nombrePlats = $request->nombrePlats;
                $commande->prixCommande = $request->nombrePlats * $plat->prix;
                $commande->numeroCommande = uniqid();
                $commande->lieuLivraison = $request->lieuLivraison;
                // dd($commande);

                $commande->save();

                return response()->json([
                    'status' => true,
                    'statut_code' => 201,
                    'message' => "Votre commande à été enregistrée avec succès",
                    'data' => $commande
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 500,
                'error' => "Une erreur est survenue lors de l'ajout de la commande, veuillez vérifier vos informations.",
                'exception' => $e
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        try {
            $user = auth()->guard('user-api')->user();

            $commande = Commande::find($id);
            // dd($commande);
            if (!$commande) {
                return response()->json([
                    'status' => false,
                    'statut_code' => 404,
                    'statut_message' => 'Cette commande n\'existe pas',
                ]);
            } elseif ($user) {
                $commande = Commande::where('user_id', $user->id)->where('id', $commande->id)->first();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'message' => "Voici les détails de la commande que vous avez faites pour ce plat.",
                    'data'  => $commande,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'status_code' => 404,
                    'message' => "Aucune commande n'a été trouvée.",
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 500,
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
    public function updateCommande(UpdateCommandeRequest $request, $id)
    {

        try {
            // $user = auth()->guard('user-api')->user();
            $user = $request->user();

            $commande = Commande::find($id);
            $plat = Plat::where('id', $commande->plat_id)->first();
            //  dd($leplat->prix);
            //    dd($commande->user_id);
            // $commandeRestaurant = Commande::where('plat')

            if ($commande === null) {
                return response()->json([
                    "status" => false,
                    "statut_code" => 404,
                    "message" => "Cette commande n'existe pas.",
                ]);
            }

            if ($user && $commande) {
                $this->authorize('updateCommande', $commande);
                $commande = Commande::where('id', $commande->id)->first(); // where('user_id', $user->id)->
                // dd($commande);
                $commande->nombrePlats = $request->nombrePlats;
                $commande->prixCommande = $request->nombrePlats * $plat->prix;
                $commande->lieuLivraison = $request->lieuLivraison;

                // dd($commande);

                $commande->update();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'message' => "Votre commande à été modifiée avec succès",
                    'data' => $commande
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function annulerCommande($id)
    {

        try {
            $commande = Commande::find($id);
            // dd($commande);

            if ($commande === null) {
                return response()->json([
                    'status' => false,
                    'statut_code' => 404,
                    'statut_message' => 'Cette commande n\'existe pas',
                ]);
            } else {
                $this->authorize('updateCommande', $commande);

                $commande->delete();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'statut_message' => 'Ce Menu a été supprimé avec succès',
                    'numeroCommande' => $commande->numeroCommande,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e->getMessage()
            ]);
        }
    }

    public function refuserCommande(Request $request, $id)
    {

        try {
            $commande = Commande::find($id);

            $this->authorize('refuserCommande', $commande);


            if ($commande === null) {
                return response()->json([
                    "status" => false,
                    "statut_code" => 404,
                    "message" => "Cette commande n'existe pas.",
                ]);
            }

            if ($commande->etatCommande === 'refusee') {
                return response()->json([
                    "status" => true,
                    "statut_code" => 200,
                    "message" => "Cette commande est déjà refusée.",
                ]);
            } elseif (isset($commande->etatCommande)) {
                // if (isset($commande->etatCommande)) {

                $commande->update(['etatCommande' => 'refusee']);
                // dd($commande);
                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'statut_message' => 'Le plat est refusee avec succès',
                    'data' => $commande,
                ]);
            }
            // }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e->getMessage()
            ]);
        }
    }

    public function accepterCommande(Request $request, $id)
    {
        try {
            $commande = Commande::find($id);

            $this->authorize('accepterCommande', $commande);

            if ($commande === null) {
                return response()->json([
                    "status" => false,
                    "statut_code" => 404,
                    "message" => "Cette commande n'existe pas.",
                ]);
            }

            if ($commande->etatCommande === 'acceptee') {
                return response()->json([
                    "status" => true,
                    "statut_code" => 200,
                    "message" => "Cette commande est déjà acceptée.",
                ]);
            } elseif ($commande) {
                if (isset($commande->etatCommande)) {

                    $commande->update(['etatCommande' => 'acceptee']);
                    // dd($commande);
                    return response()->json([
                        'status' => true,
                        'statut_code' => 200,
                        'statut_message' => 'La commande est acceptée avec succès',
                        'data' => $commande,
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e->getMessage()
            ]);
        }
    }

    // public function commandeAcceptedList(Request $request)
    // {
    //     try {
    //         $commandes = Commande::where('etatCommande', 'acceptee')->get();
    //         // dd($commandes);
            
            // $this->authorize('commandeAccepted', $commandes);

    //         return response()->json([
    //             'status' => true,
    //             'statut_code' => 200,
    //             'statut_message' => 'Liste des commandes acceptées récupérée avec succès',
    //             'data' => $commandes,
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             "status" => false,
    //             "statut_code" => 500,
    //             "message" => "Une erreur est survenue.",
    //             "error"   => $e->getMessage()
    //         ]);
    //     }
    // }

    // public function commandeRefusedList(Request $request)
    // {
    //     try {

    //         $commandes = Commande::where('etatCommande', 'refusee')->get();
    //         // dd($commandes);
    
            // $this->authorize('commandeRefused', $commandes);

    //         return response()->json([
    //             'status' => true,
    //             'statut_code' => 200,
    //             'statut_message' => 'Liste des commandes refusées récupérée avec succès',
    //             'data' => $commandes,
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             "status" => false,
    //             "statut_code" => 500,
    //             "message" => "Une erreur est survenue.",
    //             "error"   => $e->getMessage()
    //         ]);
    //     }
    // }
}

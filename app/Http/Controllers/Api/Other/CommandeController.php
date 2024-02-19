<?php

namespace App\Http\Controllers\Api\Other;

use Exception;
use App\Models\Plat;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use App\Http\Controllers\Controller;
use App\Notifications\CommandeEffectuee;
use Illuminate\Notifications\Notification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Api\Commande\CreateCommandeRequest;
use App\Http\Requests\Api\Commande\UpdateCommandeRequest;
// use Illuminate\Support\Facades\Notification;

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
                ],  400);
            }

            $plat = Plat::find($request->plat_id);

            if ($plat === null) {
                return response()->json([
                    "status" => false,
                    "statut_code" => 404,
                    "message" => "Le plat n'existe pas."
                ],   404);
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
                ],  200);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 500,
                "message" => "Une erreur est survenue.",
                "erreur" => $e->getMessage()
            ],   500);
        }
    }

    // public function getCommandebyPlats ($plat_id)
    // {
    //     try {
    //         $commandes = Commande::where('plat_id', $plat_id)->where('etatCommande', 'acceptee')->orderByDesc('created_at')->get();
    //         $plat = Plat::find($plat_id);
    //         // dd($menu);

    //         if ($plat) {
    //             return response()->json([
    //                 "status_code" => 200,
    //                 "message" => "Voici les commandes du plat:  {$plat->libelle}",
    //                 "data" => $commandes,
    //             ],  200);
    //         } elseif (!$plat) {
    //             return response()->json([
    //                 "status" => false,
    //                 "status_code" => 404,
    //                 "message" => "Désolé, ce plat n'existe pas.",
    //             ],   404);
    //         }
    //     } catch (Exception $e) {
    //         return response()->json([
    //             "status" => false,
    //             "status_code" => 500,
    //             "message" => "Une erreur est survenue lors du listage des commandes.",
    //             "error"   => $e->getMessage()
    //         ],   500);
    //     }
    // }

    public function getCommandebyPlat($plat_id)
    {
        try {
            // Récupérez le plat associé au plat_id
            $plat = Plat::find($plat_id);

            // Vérifiez si l'utilisateur actuel est le créateur du menu associé au plat
            $user = auth()->guard('user-api')->user();
            if (!$user || $plat->menu->user_id !== $user->id) {
                return response()->json([
                    "status" => false,
                    "status_code" => 403,
                    "message" => "Accès non autorisé. Vous n'êtes pas autorisé à voir les commandes de ce plat.",
                ], 403);
            }

            // Récupérez les commandes du plat
            $commandes = Commande::where('plat_id', $plat_id)->where('etatCommande', 'acceptee')->orderByDesc('created_at')->get();

            return response()->json([
                "status_code" => 200,
                "message" => "Voici les commandes du plat:  {$plat->libelle}",
                "data" => $commandes,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "status_code" => 404,
                "message" => "Désolé, ce plat n'existe pas.",
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue lors du listage des commandes.",
                "error"   => $e->getMessage()
            ], 500);
        }
    }


    // public function storeOne(CreateCommandeRequest $request, Commande $commande)
    // {
    //     try {
    //         $user = auth()->guard('user-api')->user();

    //         $commande = new Commande();

    //         $this->authorize('store', $commande);

    //         $plat = Plat::find($request->plat_id);

    //         if ($plat && $user) {
    //             $commande->user_id = $user->id;
    //             $commande->plat_id = $plat->id;
    //             $commande->nomPlat = $plat->libelle;
    //             $commande->nombrePlats = $request->nombrePlats;
    //             $commande->prixCommande = $request->nombrePlats * $plat->prix;
    //             $commande->numeroCommande = uniqid();
    //             $commande->lieuLivraison = $request->lieuLivraison;
    //             $user = auth()->guard('user-api')->user();

    //             // dd($commande);
    //             $user->notify(new CommandeEffectuee($commande));

    //             $commande->save();



    //             // Notification::send($user, new CommandeEffectuee($commande));

    //             return response()->json([
    //                 'status' => true,
    //                 'statut_code' => 201,
    //                 'message' => "Votre commande à été enregistrée avec succès",
    //                 'data' => $commande
    //             ],  201);
    //         }
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'statut_code' => 500,
    //             'error' => "Une erreur est survenue lors de l'ajout de la commande, veuillez vérifier vos informations.",
    //             'exception' => $e->getMessage()
    //         ],   500);
    //     }
    // }

    // public function addCommande(CreateCommandeRequest $request, Commande $commande)
    // {
    //     try {
    //         $user = auth()->guard('user-api')->user();

    //         $this->authorize('store', $commande);

    //         $platIds = $request->input('plat_ids'); // Assuming the request contains an array of plat_ids

    //         if (!empty($platIds) && $user) {
    //             foreach ($platIds as $platId) {
    //                 $plat = Plat::find($platId);

    //                 if ($plat) {
    //                     $commande = new Commande();

    //                     $commande->user_id = $user->id;
    //                     $commande->plat_id = $plat->id;
    //                     $commande->nomPlat = $plat->libelle;
    //                     $commande->nombrePlats = $request->nombrePlats;
    //                     $commande->prixCommande = $request->nombrePlats * $plat->prix;
    //                     $commande->numeroCommande = uniqid();
    //                     $commande->lieuLivraison = $request->lieuLivraison;

    //                     $user->notify(new CommandeEffectuee($commande));

    //                     $commande->save();
    //                 }
    //             }

    //             return response()->json([
    //                 'status' => true,
    //                 'statut_code' => 201,
    //                 'message' => "Vos commandes ont été enregistrées avec succès",
    //                 'data' => $commande
    //             ],  201);
    //         }
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'statut_code' => 500,
    //             'error' => "Une erreur est survenue lors de l'ajout de la commande, veuillez vérifier vos informations.",
    //             'exception' => $e->getMessage()
    //         ],   500);
    //     }
    // }

    public function store(CreateCommandeRequest $request, Commande $commande)
    {
        try {
            $user = auth()->guard('user-api')->user();

            $this->authorize('store', $commande);

            $commandes = $request->input('commandes');
            $plusieursCommandes = [];

            if (!empty($commandes) && $user) {
                foreach ($commandes as $oneCommande) {
                    $plat = Plat::find($oneCommande['plat_id']);

                    if ($plat) {
                        $commande = new Commande();

                        $commande->user_id = $user->id;
                        $commande->plat_id = $plat->id;
                        $commande->nomPlat = $plat->libelle;
                        $commande->nombrePlats = $oneCommande['nombrePlats'];
                        $commande->prixCommande = $oneCommande['nombrePlats'] * $plat->prix;
                        $commande->numeroCommande = uniqid();
                        $commande->lieuLivraison = $request->lieuLivraison;

                        $user->notify(new CommandeEffectuee($commande));

                        $commande->save();

                        // Ajouter la commande créée au tableau
                        $plusieursCommandes[] = $commande;
                    }
                }

                return response()->json([
                    'status' => true,
                    'statut_code' => 201,
                    'message' => "Vos commandes ont été enregistrées avec succès",
                    'data' => $plusieursCommandes
                ],  201);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 500,
                'error' => "Une erreur est survenue lors de l'ajout de la commande, veuillez vérifier vos informations.",
                'exception' => $e->getMessage()
            ],   500);
        }
    }

    // public function store(CreateCommandeRequest $request, Commande $commande)
    // {
    //     try {
    //         $user = auth()->guard('user-api')->user();
    //         $this->authorize('store', $commande);

    //         $commandes = $request->input('commandes');
    //         $plusieursCommandes = [];

    //         if (!empty($commandes) && $user) {

    //             $commandeUnique = new Commande();

    //             foreach ($commandes as $oneCommande) {
    //                 $plat = Plat::find($oneCommande['plat_id']);

    //                 if ($plat) {
    //                     // $commandeUnique->plats()->create([
    //                     //     'user_id' => $user->id,
    //                     //     'plat_id' => $plat->id,
    //                     //     'nomPlat' => $plat->libelle,
    //                     //     'nombrePlats' => $oneCommande['nombrePlats'],
    //                     //     'prixCommande' => $oneCommande['nombrePlats'] * $plat->prix,
    //                     //     'numeroCommande' => uniqid(),
    //                     //     'lieuLivraison' => $request->lieuLivraison,
    //                     // ]);

    //                     // $commande->user_id = $user->id;
    //                     // $commande->plat_id = $plat->id;
    //                     // $commande->nomPlat = $plat->libelle;
    //                     // $commande->nombrePlats = $oneCommande['nombrePlats'];
    //                     // $commande->prixCommande = $oneCommande['nombrePlats'] * $plat->prix;
    //                     // $commande->numeroCommande = uniqid();
    //                     // $commande->lieuLivraison = $request->lieuLivraison;

    //                     $commandeUnique->save();

    //                     // dd($commandeUnique);

    //                     $plusieursCommandes[] = $commandeUnique;
    //                 }
    //             }

    //             return response()->json([
    //                 'status' => true,
    //                 'statut_code' => 201,
    //                 'message' => "Vos commandes ont été enregistrées avec succès",
    //                 'data' => $plusieursCommandes
    //             ],  201);
    //         }
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'statut_code' => 500,
    //             'error' => "Une erreur est survenue lors de l'ajout de la commande, veuillez vérifier vos informations.",
    //             'exception' => $e->getMessage()
    //         ],   500);
    //     }
    // }




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
                ],  404);
            } elseif ($user) {
                $commande = Commande::where('user_id', $user->id)->where('id', $commande->id)->first();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'message' => "Voici les détails de la commande que vous avez faites pour ce plat.",
                    'data'  => $commande,
                ],   200);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 500,
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
                ],  404);
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
                ],  200);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e->getMessage()
            ],   500);
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
                ],  404);
            } else {
                $this->authorize('updateCommande', $commande);

                $commande->delete();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'statut_message' => 'Ce Menu a été supprimé avec succès',
                    'numeroCommande' => $commande->numeroCommande,
                ],   200);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e->getMessage()
            ],    500);
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
                ],  404);
            }

            if ($commande->etatCommande === 'refusee') {
                return response()->json([
                    "status" => true,
                    "statut_code" => 200,
                    "message" => "Cette commande est déjà refusée.",
                ],   200);
            } elseif (isset($commande->etatCommande)) {
                // if (isset($commande->etatCommande)) {

                $commande->update(['etatCommande' => 'refusee']);
                // dd($commande);
                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'statut_message' => 'Le plat est refusee avec succès',
                    'data' => $commande,
                ],   200);
            }
            // }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "statut_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e->getMessage()
            ],   500);
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
                ],    404);
            }

            if ($commande->etatCommande === 'acceptee') {
                return response()->json([
                    "status" => true,
                    "statut_code" => 200,
                    "message" => "Cette commande est déjà acceptée.",
                ],     200);
            } elseif ($commande) {
                if (isset($commande->etatCommande)) {

                    $commande->update(['etatCommande' => 'acceptee']);
                    // dd($commande);
                    return response()->json([
                        'status' => true,
                        'statut_code' => 200,
                        'statut_message' => 'La commande est acceptée avec succès',
                        'data' => $commande,
                    ],  200);
                }
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

    // public function commandeAcceptedList(Request $request)
    // {
    //     try {
    //         $commandes = Commande::where('etatCommande', 'acceptee')->get();
    //         // dd($commandes);

    //         $this->authorize('commandeAccepted', $commandes);

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

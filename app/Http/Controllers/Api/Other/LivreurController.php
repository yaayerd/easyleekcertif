<?php

namespace App\Http\Controllers\Api\Other;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\livreur;
use App\Models\Livraison;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\LivreurAjoute;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use App\Http\Requests\Api\User\LoginUserRequest;
use App\Http\Requests\Api\User\CreateUserRequest;
use App\Http\Requests\Api\User\UpdateUserRequest;

class LivreurController extends Controller
{
    use Notifiable;

    public function livreurRegister(CreateUserRequest $request)
    {
        // dd($request);

        $livreur = new User();

        $role_id_livreur = Role::where("nom", "Role_Livreur")->get()->first()->id;


        $livreur->role_id = $role_id_livreur;
        $livreur->name = $request->name;
        $livreur->email = $request->email;
        $livreur->phone = $request->phone;
        $livreur->adresse = $request->adresse;

        $livreur->password = Hash::make($request->password);

        // dd($livreur);


        $livreur->notify(new LivreurAjoute($livreur));

        $livreur->save();

        $livreur->livreurs()->create();

        if ($livreur) {
            return response()->json([
                'status_code' => 201,
                'status' => true,
                'message' => "Enrégistrement du livreur reussie",
                'data' =>  $livreur
            ],  201);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Echec de l'enrégistrement du livreur"
            ]);
        }
    }

    public function livreurLogin(LoginUserRequest $request, User $livreur)
    {

        // $credentials = request(['email', 'password']);
        // dd($request);
        $credentials = $request->only('email', 'password');
        if (!$token = auth()->guard('user-api')->attempt($credentials)) {
            return response()->json(['error' => 'Les informations d\'identification ne sont pas valides.'], 401);
        }

        $livreur = auth()->guard('user-api')->user();
        return response()->json([
            'status_code' => 200,
            'status_message' => "Livreur connecté avec succès",
            'livreur' => $livreur,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('user-api')->factory()->getTTL() * 120,
            'token' => $token,
        ]);
    }

    public function livreurModifyProfile(UpdateUserRequest $request, User $livreur)
    {
        try {
            // Vérifier si l'utilisateur connecté est le propriétaire du compte (livreur)
            $user = $request->user();
            if ($user->id !== $livreur->id) {
                return response()->json([
                    'status' => false,
                    'statut_code' => 403,
                    'error' => "Vous n'êtes pas autorisé à modifier ce profil, il ne vous appartient point.",
                ], 403);
            }

            $livreur->name = $request->name;
            $livreur->email = $request->email;
            $livreur->phone = $request->phone;
            $livreur->adresse = $request->adresse;

            $livreur->password = Hash::make($request->password);

            $livreur->save();

            // Retourner une réponse en fonction du résultat de la modification
            return response()->json([
                'status' => true,
                'statut_code' => 200,
                'message' => "Profil du livreur modifié avec succès",
                'data' => $livreur
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 500,
                'error' => "Une erreur est survenue lors de la modification du profil du livreur.",
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function putStatutOccupe(Request $request, $id)

    {
        $livreur = Livreur::find($id);
        // dd($livreur);

        try {
            $user = $request->user();
            if ($livreur && $user) {

                if ($livreur === null) {
                    return response()->json([
                        "status" => false,
                        "statut_code" => 404,
                        "message" => "Ce livreur n'existe pas sur notre plateforme.",
                    ],  404);
                } elseif ($user->role_id != 4 && $livreur->id == $request->user()->id) {
                    return response()->json([
                        "status" => false,
                        "statut_code" => 403,
                        "message" => "Vous ne pouvez pas modifier le statut car vous n'êtes pas livreur sur notre plateforme."
                    ], 403);
                } else {


                    $livreur->update([
                        'statutLivreur' => 'occupe',
                    ]);
                    // dd($livreur);
                    return response()->json([
                        "status" => true,
                        "statut_code"  => 200,
                        "message" => "Vous êtes marqué comme indisponible en ce moment.",
                        "statut actuel" => $livreur->statutLivreur,
                        'votre id' => $livreur->id,
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'phone' => $user->phone,
                        'adresse' => $user->adresse,
                    ], 200);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e->getMessage()
            ],   500);
        }
    }

    public function getLivreursDisponibles(Request $request)
    {
        try {
            if (auth()->user() && auth()->user()->role_id !== 3) {
                $livreurs = User::where('role_id', 4)->get();

                $livreursDisponibles = Livreur::where('statutLivreur', 'disponible')->get();

                $livreursInfo = [];

                foreach ($livreursDisponibles as $livreurDisponible) {
                    $livreurInfo = [
                        'user_id' => $livreurDisponible->user_id,
                        'name' => $livreurDisponible->user->name,
                        'phone' => $livreurDisponible->user->phone,
                        'adresse' => $livreurDisponible->user->adresse,
                        'statutLivreur' => $livreurDisponible->statutLivreur,
                    ];

                    $livreursInfo[] = $livreurInfo;
                }

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'message' => 'Voici la liste des livreurs disponibles.',
                    'data' => $livreursInfo,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'statut_code' => 403,
                    'error' => "En tant que client, vous n'avez pas accès à ces ressources.",
                ], 403);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 500,
                'error' => "Une erreur est survenue lors de la récupération des livreurs disponibles.",
                'exception' => $e->getMessage(),
            ], 500);
        }
    }


    public function getLivreursOccupes()
    {
        try {
            if (auth()->user() && auth()->user()->role_id !== 3) {
                $livreurs = User::where('role_id', 4)->get();

                $livreursOccupes = Livreur::where('statutLivreur', 'occupe')->get();

                $livreursInfo = [];

                foreach ($livreursOccupes as $livreurOccupe) {
                    $livreurInfo = [
                        'user_id' => $livreurOccupe->user_id,
                        'name' => $livreurOccupe->user->name,
                        'phone' => $livreurOccupe->user->phone,
                        'adresse' => $livreurOccupe->user->adresse,
                        'statutLivreur' => $livreurOccupe->statutLivreur,
                    ];

                    $livreursInfo[] = $livreurInfo;
                }

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'message' => 'Voici la liste des livreurs occupes.',
                    'data' => $livreursInfo,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'statut_code' => 403,
                    'error' => "En tant que client, vous n'avez pas accès à ces ressources.",
                ], 403);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 500,
                'error' => "Une erreur est survenue lors de la récupération des livreurs occupes.",
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

    public function getDetailsLivreur($livreurId)
    {
        try {
            if (auth()->user() && auth()->user()->role_id !== 3) {
                $livreur = Livreur::find($livreurId);

                if ($livreur) {
                    $livreurDetails = [
                        'user_id' => $livreur->user_id,
                        'livreur_id' => $livreur->id,
                        'name' => $livreur->user->name,
                        'phone' => $livreur->user->phone,
                        'adresse' => $livreur->user->adresse,
                        'role' => $livreur->user->role->nom,
                        'statut_livreur' => $livreur->statutLivreur,
                    ];

                    return response()->json([
                        'status' => true,
                        'statut_code' => 200,
                        'message' => 'Voici les details du livreur: ' . $livreur->user->name,
                        'data' => $livreurDetails,
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'statut_code' => 404,
                        'error' => "Ce livreur est non trouvé.",
                    ], 404);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'statut_code' => 403,
                    'error' => "En tant que client, vous n'avez pas accès à ces ressources.",
                ], 403);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 500,
                'error' => "Une erreur est survenue lors de la récupération des détails du livreur.",
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

    public function accepterLivraison(Request $request, Livraison $livraison)
    {
        try {
            $livraison = Livraison::find($livraison);
            // $request->user() && auth()->user()->id
            dd($livraison);
            if ($livraison->livreur->user_id === $request->user()->id) {
                $livraison->etatLivraison = 'en_cours';
                $livraison->save();
                                
                $livraison->livreur->statutLivreur = 'occupe';
                $livraison->livreur->save();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'message' => "Livraison acceptée avec succès.",
                    'data' => [
                        'livraison' => $livraison,
                        'livreur' => $livraison->livreur->user,
                        'commande' => $livraison->commande,
                    ],
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'statut_code' => 403,
                    'error' => "Vous n'avez pas l'autorisation d'accepter cette livraison.",
                ], 403);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 500,
                'error' => "Une erreur est survenue lors de l'acceptation de la livraison.",
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

    public function terminerLivraison($livraison_id)
    {
        try {
            $livraison = Livraison::find($livraison_id);

            if (auth()->user() && $livraison->livreur->user_id === auth()->user()->id) {
                $livraison->etatLivraison = 'effectuee';
                $livraison->save();

                $livraison->livreur->statutLivreur = 'disponible';
                $livraison->livreur->save();

                return response()->json([
                    'status' => true,
                    'statut_code' => 200,
                    'message' => "Livraison terminée avec succès.",
                    'data' => [
                        'livraison' => $livraison,
                        'livreur' => $livraison->livreur->user,
                        'commande' => $livraison->commande,
                    ],
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'statut_code' => 403,
                    'error' => "Vous n'avez pas l'autorisation de terminer cette livraison.",
                ], 403);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 500,
                'error' => "Une erreur est survenue lors de la fin de la livraison.",
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

    public function refuserLivraison($livraison_id)
    {
        try {
            $livraison = Livraison::find($livraison_id);

            if (auth()->user() && $livraison->livreur->user_id === auth()->user()->id) {
                if ($livraison->livreur->statutLivreur === 'occupe') {
                    $livraison->etatLivraison = 'affectee';
                    $livraison->save();

                    return response()->json([
                        'status' => true,
                        'statut_code' => 200,
                        'message' => "Livraison refusée avec succès.",
                        'data' => $livraison,
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'statut_code' => 400,
                        'error' => "La livraison ne peut pas être acceptée car le livreur est occupé.",
                    ], 400);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'statut_code' => 403,
                    'error' => "Vous n'avez pas l'autorisation de refuser cette livraison.",
                ], 403);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'statut_code' => 500,
                'error' => "Une erreur est survenue lors du refus de la livraison.",
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}

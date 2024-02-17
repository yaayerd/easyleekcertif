<?php

namespace App\Http\Controllers\Api\Other;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\livreur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\LivreurAjoute;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use App\Http\Requests\Api\User\LoginUserRequest;
use App\Http\Requests\Api\User\CreateUserRequest;

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

    public function putStatutOccupe(Request $request, $id)

    {
        $livreur = Livreur::find($id);
        try {
            $livreur = $request->user();
            if ($livreur) {

                if ($livreur === null) {
                    return response()->json([
                        "status" => false,
                        "statut_code" => 404,
                        "message" => "Ce livreur n'existe pas sur notre plateforme.",
                    ],  404);
                } elseif ($livreur->role != 4) {
                    return response()->json([
                        "status" => false,
                        "statut_code" => 403,
                        "message" => "Vous ne pouvez pas modifier le statut car vous n'êtes pas livreur sur notre plateforme."
                    ], 403);
                } else {

                    $request->validate([
                        'statut' => 'required|in:disponible,occupe',
                    ]);

                    $livreur->update([
                        'statutLivreur' => 'occupe',
                    ]);
                    return response()->json([
                        "status" => true,
                        "statut_code"  => 200,
                        "message" => "Vous êtes marqué comme indisponible en ce moment.",
                        "data" => $livreur
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


}

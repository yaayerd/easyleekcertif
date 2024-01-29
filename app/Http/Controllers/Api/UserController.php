<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\CreateUserRequest;
use App\Http\Requests\Api\User\LoginUserRequest;
use App\Http\Requests\Api\User\UpdateUserRequest;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function userRegister(CreateUserRequest $request)
    {

        // dd($request);
        // $role_id_Client = Role::where("nom", "Client")->get()->first()->id;
        // $user->role_id = $role_id_Client;

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->adresse = $request->adresse;
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $user['image'] = $filename;
        }
        $user->password = Hash::make($request->password);
        $user->save();

        if ($user) {
            return response()->json([
                'status_code' => 200,
                'status' => true,
                'message' => "Inscription de l'utilisateur reussie",
                'data' =>  $user,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Echec de l'inscription de l'utilisateur"
            ]);
        }
    }

    public function userLogin(LoginUserRequest $request, User $user)
    {

        // $credentials = request(['email', 'password']);
        // dd($request);
        $credentials = $request->only('email', 'password');
        if (!$token = auth()->guard('user-api')->attempt($credentials)) {
            return response()->json(['error' => 'Les informations d\'identification ne sont pas valides.'], 401);
        }

        $user = auth()->guard('user-api')->user();
        return response()->json([
            'status_code' => 200,
            'status_message' => "Utilisateur connecté avec succès",
            'user' => $user,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('user-api')->factory()->getTTL() * 120
        ]);
    }


    public function userMe()
    {
        return response()->json(auth()->guard('user-api')->user());
    }

    public function userModifyProfile(UpdateUserRequest $request, User $user)
    {

        // $user = auth()->guard('user-api')->user();
        // dd($user);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->adresse = $request->adresse;

        // Mise à jour du mot de passe si fourni
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Traitement de la nouvelle image si fournie
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $user->image = $filename;
        }

        $user->save();

        // Retourner une réponse en fonction du résultat de la modification
        return response()->json([
            'status_code' => 200,
            'status' => true,
            'message' => "Profil du restaurant modifié avec succès",
            'data' => $user
        ]);
    }

    public function userLogout()
    {
        auth()->guard('user-api')->logout();

        return response()->json([
            'status_code' => 200,
            'message' => 'Deconnexion réussie'
        ]);
    }


    // Methode RESTAURANTS 

    public function restaurantRegister(CreateUserRequest $request)
    {

        $restaurant = new User();
        $role_id_restaurant = Role::where("nom", "Role_RESTAURANT")->get()->first()->id;
        $restaurant->role_id = $role_id_restaurant;
        $restaurant->categorie_id = $request->categorie_id;
        $restaurant->name = $request->name;
        $restaurant->email = $request->email;
        $restaurant->phone = $request->phone;
        $restaurant->adresse = $request->adresse;
        $restaurant->password = Hash::make($request->password);
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $user['image'] = $filename;
        }
        $restaurant->save();

        if ($restaurant) {
            return response()->json([
                'status_code' => 200,
                'status' => true,
                'message' => "Enrégistrement du Restaurant reussie",
                'data' =>  $restaurant
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Echec de l'enrégistrement du Restaurant"
            ]);
        }
    }

    public function restaurantLogin(LoginUserRequest $request, User $restaurant)
    {
        
        // dd($request);
        $credentials = $request->only(['email', 'password']);
        if (!$token = auth()->guard('user-api')->attempt($credentials)) {
            return response()->json(['error' => 'Les informations d\'identification ne sont pas valides.'], 401);
        }
        
        $restaurant = auth()->guard('user-api')->user();

        return response()->json([
            'status_code' => 200,
            'status_message' => "Utilisateur connecté avec succès",
            'restaurant' => $restaurant,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('user-api')->factory()->getTTL() * 120
        ]);
    }


    public function restaurantMe()
    {
        return response()->json(auth()->guard('user-api')->user());
    }

    public function restaurantLogout()
    {
        auth()->guard('user-api')->logout();

        return response()->json([
            'status_code' => 200,
            'message' => 'Deconnexion réussie'
        ]);
    }

    public function restautantModifyProfile(UpdateUserRequest $request, User $restaurant)
    {

        // $restaurant = auth()->guard('user-api')->user();
        // $categorieId = $user->categorie_id;
        $restaurant->categorie_id = $request->categorie_id;
        $restaurant->name = $request->name;
        $restaurant->email = $request->email;
        $restaurant->phone = $request->phone;
        $restaurant->adresse = $request->adresse;
        // dd($restaurant);

        // Mise à jour du mot de passe si fourni
        if ($request->filled('password')) {
            $restaurant->password = Hash::make($request->password);
        }

        // Traitement de la nouvelle image si fournie
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $restaurant->image = $filename;
        }

        // Enregistrement des modifications
        $restaurant->save();

        // Retourner une réponse en fonction du résultat de la modification
        return response()->json([
            'status_code' => 200,
            'status' => true,
            'message' => "Profil du restaurant modifié avec succès",
            'data' => $restaurant
        ]);
    }
}

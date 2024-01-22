<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller 
{
    public function userRegister(Request $request){

        $user = new User();
        // $role_id_Client = Role::where("nom", "Client")->get()->first()->id;
        $user->name = $request->name;
        // $user->role_id = $role_id_Client;
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

        if($user){
            return response()->json([
            'status_code' => 200,
            'status'=>true,
            'message'=> "Inscription de l'utilisateur reussie",
            'data'=>  $user,
        ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=> "Echec de l'inscription de l'utilisateur"
            ]);

        }

    }

    public function userLogin(Request $resquest){
       
        $credentials = request(['email', 'password']);
        
        if (! $token = auth()->guard('user-api')->attempt($credentials)) {
            // return response()->json(['error' => 'Token inexistant'], 401);
        }
        
        $user = auth()->guard('user-api')->user();
        return response()->json([
            'status_code'=>200,
            'status_message'=> "Utilisateur connecté avec succès",
            'user'=> $user,
            'token'=> $token
        ]);
    }


    public function userMe()
    {
        return response()->json(auth()->guard('user-api')->user());
    }

    public function userModifyProfile(Request $request, User $user)
    {

        $user = auth()->guard('user-api')->user();
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
            'status_code'=>200,
            'message' => 'Deconnexion réussie'
        ]);
    }


    // Methode RESTAURANTS 
    
    public function restaurantRegister(Request $request){

        $restaurant = new User();
        $role_id_restaurant = Role::where("nom", "Restaurant")->get()->first()->id;
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

        if($restaurant){
            return response()->json([
            'status_code' => 200,
            'status'=>true,
            'message'=> "Enrégistrement du Restaurant reussie",
            'data'=>  $restaurant
        ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=> "Echec de l'enrégistrement du Restaurant"
            ]);

        }

    }

    public function restaurantLogin(Request $resquest){
       
        $credentials = request(['email', 'password']);
        if (! $token = auth()->guard('user-api')->attempt($credentials)) {
            return response()->json(['error' => 'Token inexistant'], 401);
        }
        // return $token;
            
        $restaurant = auth()->guard('user-api')->user();
            return response()->json([
                'status_code'=>200,
                'status_message'=> "Restaurant connecté avec succès",
                'data'=> $restaurant,
                'token'=> $token
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
            'status_code'=>200,
            'message' => 'Deconnexion réussie'
        ]);
    }

    public function restautantModifyProfile(Request $request, User $restaurant)
{
    // Validation des données de la requête
    // $request->validate([
    //     'categorie_id' => 'required',
    //     'name' => 'required',
    //     'email' => 'required|email|unique:users,email,' . auth()->user()->id,
    //     'phone' => 'required',
    //     'adresse' => 'required',
    //     'password' => 'nullable|min:6',
    //     'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Ajoutez d'autres règles de validation pour l'image si nécessaire
    // ]);

    $restaurant = auth()->guard('user-api')->user();
    // dd($restaurant);
    $restaurant->categorie_id = $request->categorie_id;
    $restaurant->name = $request->name;
    $restaurant->email = $request->email;
    $restaurant->phone = $request->phone;
    $restaurant->adresse = $request->adresse;

    // Mise à jour du mot de passe si fourni
    // if ($request->filled('password')) {
    //     $restaurant->password = Hash::make($request->password);
    // }

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

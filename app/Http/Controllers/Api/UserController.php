<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function userRegister(Request $request){

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->adresse = $request->adresse;
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
        
        if (! $token = auth()->guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        // $user = auth()->guard('api')->user(); ->guard('api')
        $user = auth()->user();
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

    public function userLogout()
    {
        auth()->guard('user-api')->logout();

        return response()->json([
            'status_code'=>200,
            'message' => 'Deconnexion réussie'
        ]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
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

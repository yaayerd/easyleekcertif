<?php

namespace App\Http\Controllers\Api;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class RestaurantController extends Controller
{
    public function restaurantRegister(Request $request){

        $restaurant = new Restaurant();
        $restaurant->name = $request->name;
        $restaurant->email = $request->email;
        $restaurant->phone = $request->phone;
        $restaurant->adresse = $request->adresse;
        $restaurant->password = Hash::make($request->password);
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $restaurant['image'] = $filename;
        }
        // dd($restaurant);
        $restaurant->save();

        if($restaurant){
            return response()->json([
            'status_code' => 200,
            'status'=>true,
            'message'=> "Enrégistrement du Restaurant reussie",
            'data'=>  $restaurant,
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
        if (! $token = auth('api')->guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Token inexistant'], 401);
        }
        // return $token;
            
            $restaurant = auth()->user();
            // dd($restaurant);
            return response()->json([
                'status_code'=>200,
                'status_message'=> "Restaurant connecté avec succès",
                'restaurant'=> $restaurant,
                'token'=> $token
            ]);
    }


    public function restaurantMe()
    {
        return response()->json(auth()->guard('restaurant-api')->user());
    }

    public function restaurantLogout()
    {
        auth()->guard('restaurant-api')->logout();

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

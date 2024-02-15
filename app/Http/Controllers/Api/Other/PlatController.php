<?php

namespace App\Http\Controllers\Api\Other;

use Exception;
use App\Models\Menu;
use App\Models\Plat;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Plat\CreatePlatRequest;
use App\Http\Requests\Api\Plat\UpdatePlatRequest;

class PlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $menu = Menu::find($request->menu_id);
            // dd($menu);
            
            if ($menu) { // && $user->role_id == 2 && $menu->user_id == $user->id
                $plats = $menu->plats()->where('is_archived', false)->orderByDesc('created_at')->get();
                // dd($plats);
                return response()->json([
                    "status code" => 200,
                    "message" => "Voici les plats du menu:  {$menu->titre}",
                    'plats' => $plats,
                ],  200);
            } 
            elseif ($menu === null) {
                return response()->json([
                    "status" => false,
                    "status_code" => 404,
                    "message" => "Désolé, ce menu n'existe pas dans aucun restaurant.",
                ],  404);
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

    public function indexForRestaurant(Request $request, Menu $menu)
    {
        try {
            $user = auth()->user();
            $plats = Plat::where('menu_id', $menu->id)->where('is_archived', false)->orderByDesc('created_at')->get();
            // $user_ok = User::where('id', $menu->user_id)->first();
            // $menu = Menu::find($request->menu_id);
            // $user_id = Menu::find($request->user_id);
            // dd($menu);

            if ( $user->role_id === 2 && $menu->user_id === auth()->user()->id) { 
                
                return response()->json([
                    "status_code" => 201,
                    "message" => "Voici les plats du menu:  {$menu->titre} du restaurant {$user->name}.",
                    "user_id" =>  auth()->user()->id,
                    "data" => $plats,
                    // $menu->plats()->where('is_archived', false)->orderByDesc('created_at')->get(),
                ],  200);
            } elseif ($menu->user_id != auth()->user()->id) {
                return response()->json([
                    "status" => false,
                    "status_code" => 403,
                    "message" => "Vous n'êtes pas autorisé à lister ces plats, car ce menu ne fait pas parti de votre restaurant.",
                ],  403);
            } elseif (!$menu) {
                return response()->json([
                    "status" => false,
                    "status_code" => 404,
                    "message" => "Désolé, ce menu n'existe pas dans aucun restaurant.",
                ],   404);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue lors du listage des plats.",
                "error"   => $e->getMessage()
            ],   500);
        }
    }

    public function getPlatbyMenu ($menu_id)
    {
        try {
            $plats = Plat::where('menu_id', $menu_id)->where('is_archived', false)->orderByDesc('created_at')->get();
            $menu = Menu::find($menu_id);
            // dd($menu);

            if ($menu) {
                return response()->json([
                    "status_code" => 201,
                    "message" => "Voici les plats du menu:  {$menu->titre} de ce restaurant.",
                    "data" => $plats,
                ],  200);
            } elseif (!$menu) {
                return response()->json([
                    "status" => false,
                    "status_code" => 404,
                    "message" => "Désolé, ce menu n'existe pas dans aucun restaurant.",
                ],   404);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue lors du listage des plats.",
                "error"   => $e->getMessage()
            ],   500);
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
    public function store(CreatePlatRequest $request, Plat $plat) // Plat $plat
    {
        try {
            $user = $request->user();
            $menu = Menu::find($request->menu_id);
            // dd($menu);

            if ($user && $user->role_id == 2 && $menu && $menu->user_id == $user->id) {

                $this->authorize('store', $plat);

                $plat = new Plat();

                $plat->libelle = $request->libelle;
                // dd($plat);
                $plat->prix = $request->prix;
                $plat->descriptif = $request->descriptif;
                $plat->menu_id = $request->menu_id;
                // $plat->image = $request->image;
                if ($request->file('image')) {
                    $file = $request->file('image');
                    $filename = date('YmdHi') . $file->getClientOriginalName();
                    $file->move(public_path('images'), $filename);
                    $plat['image'] = $filename;
                }

                // dd($plat);

                $plat->save();

                return response()->json([
                    'status' => true,
                    'statut code' => 201,
                    'message' => "Le plat enrégistré avec succès",
                    'data'  => $plat,
                ],  201);
            } else {
                return response()->json([
                    'status' => false,
                    'status_code' => 403,
                    'message' => "Vous n'avez pas l'autorisation pour ajouter un plat à ce menu il n'est pas vôtre.",
                ], 403);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue lors de l'insertion.",
                "error"   => $e->getMessage()
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
            if ($user && $user->role_id == 2) {
                $plat = Plat::find($id);
                // dd($plat);
                if ($plat === null) {
                    return response()->json([
                        'status' => false,
                        'statut_code' => 404,
                        'statut_message' => 'Ce plat n\'existe pas',
                    ],  404);
                } else {

                    return response()->json([
                        'status' => true,
                        'statut_code' => 200,
                        'statut_message' => 'Voici le plat du restaurant',
                        'data' => $plat,
                    ],   200);
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
    /**
     * Archive the specified resource in storage.
     */
    public function archiver(Request $request, $id)
    {

        $plat = Plat::find($id);
        try {
            $user = $request->user();
            if ($user) {
                // dd($plat);
                $this->authorize('archiver', $plat);

                if ($plat === null) {
                    return response()->json([
                        "status" => false,
                        "statut_code" => 404,
                        "message" => "Ce plat n'existe pas dans le menu.",
                    ],  404);
                } else {
                    if ($plat->is_archived === 1) {
                        return response()->json([
                            "status" => true,
                            "statut_code" => 200,
                            "message" => "Ce plat est déjà archivé, il n'est plus disponible dans le menu.",
                        ],   200);
                    } else {

                        // $plat->is_archived = $request->is_archived;

                        $plat->update(['is_archived' => true]);

                        return response()->json([
                            'status' => true,
                            'statut_code' => 200,
                            'statut_message' => 'Le plat est archivé avec succès',
                            'data' => $plat,
                        ],  200);
                    }
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

    public function desarchiver(Request $request, $id)
    {
        $plat = Plat::find($id);
        try {
            $user = $request->user();
            if ($user) {

                $this->authorize('desarchiver', $plat);

                if ($plat === null) {
                    return response()->json([
                        "status" => false,
                        "statut_code" => 404,
                        "message" => "Ce plat n'existe pas dans le menu.",
                    ],  404);
                } else {
                    if ($plat->is_archived === 0) {
                        return response()->json([
                            "status" => true,
                            "statut_code" => 200,
                            "message" => "Ce plat est déjà désarchivé, il est donc disponible dans le menu.",
                        ],   200);
                    } else {

                        // $plat->is_archived = $request->is_archived;

                        $plat->update(['is_archived' => false]);

                        return response()->json([
                            'status' => true,
                            'statut_code' => 200,
                            'statut_message' => 'Le plat est désarchivé avec succès, retrouvez le dans votre menu.',
                            'data' => $plat,
                        ],   200);
                    }
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

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlatRequest $request,  $id)
    {

        $plat = Plat::find($id);
        try {
            $user = $request->user();
            if ($user) {

                // dd($plat);

                if ($plat === null) {
                    return response()->json([
                        "status" => false,
                        "statut_code" => 404,
                        "message" => "Ce plat n'existe pas.",
                    ],  404);
                } else {
                    $this->authorize('update', $plat);

                    $plat->libelle = $request->libelle;
                    $plat->prix = $request->prix;
                    $plat->descriptif = $request->descriptif;
                    $plat->menu_id = $request->menu_id;
                    if ($request->file('image')) {
                        $file = $request->file('image');
                        $filename = date('YmdHi') . $file->getClientOriginalName();
                        $file->move(public_path('images'), $filename);
                        $plat['image'] = $filename;
                    }

                    $plat->update();

                    return response()->json([
                        'status' => true,
                        'statut_code' => 200,
                        'statut_message' => 'Le plat a été modifié avec succès',
                        'data' => $plat,
                    ],  200);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue lors de la mise à jour.",
                "error"   => $e->getMessage()
            ],  500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {

        $plat = Plat::find($id);
        try {
            $user = $request->user();
            if ($user) {

                if ($plat === null) {
                    return response()->json([
                        'status' => false,
                        'statut_code' => 404,
                        'statut_message' => 'Ce plat n\'existe pas',
                    ],   404);
                } else {
                    $this->authorize('delete', $plat);

                    $plat->delete();

                    return response()->json([
                        'status' => true,
                        'statut_code' => 200,
                        'statut_message' => 'Ce plat a été supprimé avec succès',
                        'data' => $plat,
                    ],  200);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e->getMessage()
            ],  500);
        }
    }

    
}

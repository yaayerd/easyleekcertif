<?php

namespace App\Http\Controllers\Api\Other;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Role\CreateRoleRequest;
use App\Http\Requests\Api\Role\UpdateRoleRequest;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            if ($user && $user->role_id == 1) {
                return response()->json([
                    'status' => true,
                    'status_code' => 200,
                    'message' => "Voici les rôles de la plateforme Easyleek.",
                    'roles'  => Role::all(),
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "status_code" => 401,
                    "message" => "Vous n'avez pas le rôle requis pour accéder à cette ressource."
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e
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
    public function store(CreateRoleRequest $request, Role $role)
    {
        $this->authorize('store', $role);
        try {
            $user = $request->user();
            if ($user && $user->role_id == 1) {
                $role = new Role();
                $role->nom = $request->nom;
                $role->save();

                return response()->json([
                    'status' => true,
                    'statut code' => 200,
                    'message' => "Le role enrégistré avec succès",
                    'role'  => $role,
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "status_code" => 401,
                    "message" => "Vous n'avez pas le rôle requis pour accéder à cette ressource."
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e
            ]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        try {
            $user = $request->user();
            if ($user && $user->role_id == 1) {
                $role = Role::find($id);
                if ($role === null) {
                    return response()->json([
                        'status' => false,
                        'status_code' => 404,
                        'message' => 'Ce role n\'existe pas',
                    ]);
                } else {
                    return response()->json([
                        'status' => true,
                        'status_code' => 200,
                        'message' => 'Ceci est le rôle sélectionné.',
                        'role' => $role,
                    ]);
                }
            } else {
                return response()->json([
                    "status" => false,
                    "status_code" => 401,
                    "message" => "Vous n'avez pas le rôle requis pour accéder à cette ressource."
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e
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
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);

        try {
            $user = $request->user();
            if ($user && $user->role_id == 1) {
                // $role = Role::find($id);
                if ($role === null) {
                    return response()->json([
                        "status" => false,
                        "status_code" => 404,
                        "message" => "Ce role n'existe pas.",
                    ]);
                } else {
                    $role->nom = $request->nom;
                    $role->update();

                    return response()->json([
                        'status' => true,
                        'status_code' => 200,
                        'message' => 'Le nom du role a été modifié avec succès',
                        'role' => $role,
                    ]);
                }
            } else {
                return response()->json([
                    "status" => false,
                    "status_code" => 401,
                    "message" => "Vous n'avez pas le rôle requis pour accéder à cette ressource."
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue lors de l'insertion.",
                "error"   => $e
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Role $role)
    {
        $this->authorize('desarchiver', $role);

        try {
            $user = $request->user();
            if ($user && $user->role_id == 1) {
                // $role = Role::find($id);
            //    dd($role);
                if ($role === null) {
                    return response()->json([
                        'status' => false,
                        'status_code' => 404,
                        'message' => 'Ce role n\'existe pas',
                    ]);
                } else {
                    $role->delete();
    
                    return response()->json([
                        'status' => true,
                        'status_code' => 200,
                        'message' => 'Ce role a été supprimé avec succès',
                        'role' => $role,
                    ]);
                }
            } else {
                return response()->json([
                    "status" => false,
                    "status_code" => 401,
                    "message" => "Vous n'avez pas le rôle requis pour accéder à cette ressource."
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e
            ]);
        }
    }
}

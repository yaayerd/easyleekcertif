<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): bool
    {
        return true ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function store(User $user): Response
    {
        return $user->role_id === 1
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour créer un role');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response // && $user->id === $role->user_id
    {
        return $user->role_id === 1 
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour modifier ce role');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function destroy(User $user): Response
    {
        return $user->role_id === 1
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour supprimer un role');
    }

}

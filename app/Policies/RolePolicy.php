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
    public function update(User $user, Role $role): Response
    {
        return $user->role_id === 1 && $user->id === $role->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour modifier un role');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function destroy(User $user, Role $role): Response
    {
        return $user->role_id === 1 && $user->id === $role->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour supprimer un role');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $role): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $role): bool
    {
        //
    }
}

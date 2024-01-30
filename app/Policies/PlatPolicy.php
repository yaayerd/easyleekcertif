<?php

namespace App\Policies;

use App\Models\Plat;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlatPolicy
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
    public function view(User $user, Plat $plat): bool
    {
        return true ; 
    }

    /**
     * Determine whether the user can create models.
     */
    public function store(User $user): Response
    {
        return $user->role_id === 2
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour créer un plat');
    }

    /**
     * Determine whether the user can update the model..
     */
    public function update(User $user, Plat $plat): Response
    {
        // dd($plat->menu->user_id);
        return $user->role_id === 2 && $user->id === $plat->menu->user_id
        ? Response::allow()
        : Response::deny('Vous n\'avez pas les droits pour modifier ce plat');
    }
    
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Plat $plat): Response
    {
        return $user->role_id === 2 && $user->id === $plat->menu->user_id
        ? Response::allow()
        : Response::deny('Vous n\'avez pas les droits pour supprimer ce plat');
    }
    /**
     * Determine whether the user can restore the model.
     */
    public function archiver(User $user, Plat $plat): Response
    {
        // dd($plat->menu->user_id);
        return $user->role_id === 2 && $user->id === $plat->menu->user_id
        ? Response::allow()
        : Response::deny('Vous n\'avez pas les droits pour archiver ce plat');
}

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function desarchiver(User $user, Plat $plat): Response
    {
        return $user->role_id === 2 && $user->id === $plat->menu->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour désarchiver ce plat');
    }
}

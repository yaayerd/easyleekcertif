<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MenuPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Menu $menu): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */

    public function store(User $user, Menu $menu) :Response
    {
        return $user->role_id === 2
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour créer un menu');
    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Menu $menu): Response 
    {
        return $user->role_id === 2 && $user->id === $menu->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour modifier un menu');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function destroy(User $user, Menu $menu): Response 
    {
        return $user->role_id === 2 && $user->id === $menu->user_id
        ? Response::allow()
        : Response::deny('Vous n\'avez pas les droits pour supprimer ce menu');
}

}

<?php

namespace App\Policies;

use App\Models\Avis;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AvisPolicy
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
    public function view(User $user, Avis $avis): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function store(User $user): Response
    {
        return $user->role_id === 3
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour faire un avis sur une commande.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Avis $avis): Response
    {
        return $user->role_id === 3 && $user->id === $avis->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour modifier un avis.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function destroy(User $user, Avis $avis): Response
    {
        return $user->role_id === 3 && $user->id === $avis->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour modifier un avis.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Avis $avis): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Avis $avis): bool
    {
        //
    }
}

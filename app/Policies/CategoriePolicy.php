<?php

namespace App\Policies;

use App\Models\Categorie;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoriePolicy
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
    public function view(User $user, Categorie $categorie): bool
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
        : Response::deny('Vous n\'avez pas les droits pour créer une categorie.');
}

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Categorie $categorie): Response
    {
        return $user->role_id === 1 // && $user->id === $categorie->user_id
        ? Response::allow()
        : Response::deny('Vous n\'avez pas les droits pour modifier une categorie.');
}

    /**
     * Determine whether the user can delete the model.
     */
    public function destroy(User $user, Categorie $categorie): Response
    {
        return $user->role_id === 1 // && $user->id === $categorie->user_id
        ? Response::allow()
        : Response::deny('Vous n\'avez pas les droits pour supprimer une categorie.');
}

}

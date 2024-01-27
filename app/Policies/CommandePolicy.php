<?php

namespace App\Policies;

use App\Models\Commande;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommandePolicy
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
    public function view(User $user, Commande $commande): bool
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
            : Response::deny('Vous n\'avez pas les droits pour faire une commande.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateCommande(User $user, Commande $commande): Response
    {
        return $user->role_id === 3 && $user->id === $commande->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour modifier une commande.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function annulerCommande(User $user, Commande $commande): Response
    {
        return $user->role_id === 3 && $user->id === $commande->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour annuler une commande.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function refuserCommande(User $user, Commande $commande): Response
    {
        return $user->role_id === 3 && $user->id === $commande->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour refuser une commande.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function accepterCommande(User $user, Commande $commande): Response
    {
        return $user->role_id === 3 && $user->id === $commande->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour accepter une commande.');
    }
}

<?php

namespace App\Policies;

use App\Models\Avis;
use App\Models\User;
use App\Models\Commande;
use Illuminate\Auth\Access\Response;
use Illuminate\Console\Command;

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
    public function avisStore(User $user): Response
    {
        $commande = Commande::where('user_id', $user->id)->first();  
        // $commandeDonnee = Commande::where($user->id === $commande->user_id)->first();
        // $commande = Commande::where('user_id', $user->id)->where('id', $id)->first();
        //    dd($commande);
        //->where($user->id === $commande->user_id)
        return $commande && $user->role_id === 3 && $user->id ===  $commande->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour faire un avis sur une commande.');

        //Je veux specifier que le user connecté ne peut faire un avis que sur une commande qu'il a fait lui-meme et non des commandes faits pas les autres users
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Avis $avis): Response
    {
        return $user->role_id === 3 && $user->id === $avis->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour modifier cet avis.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function destroy(User $user, Avis $avis): Response
    {
        // dd($avis);
        return $user->role_id === 3 && $user->id === $avis->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour supprimer cet avis.');
    }

}

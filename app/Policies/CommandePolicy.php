<?php

namespace App\Policies;

use App\Models\Commande;
use App\Models\Plat;
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
        // dd("bonjour");
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
       
        $platcommander= Plat::where('id',$commande->plat_id )->first();
        //dd($platcommander->menu->user_id,$user->id );


        return $user->role_id === 2 && $user->id === $platcommander->menu->user_id
            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour refuser une commande.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function accepterCommande(User $user, Commande $commande): Response
    {       
        $platcommander= Plat::where('id',$commande->plat_id )->first();
        return $user->role_id === 2 && $user->id === $platcommander->menu->user_id

            ? Response::allow()
            : Response::deny('Vous n\'avez pas les droits pour accepter une commande.');
    }

    // public function commandeAccepted(User $user, Commande $commande): Response
    // {       
    //     // $commandeAccepted= Plat::where('id',$commande->plat_id )->get()  ;//->where('etatCommande', 'acceptee')->first();
    //     dd($commande);

    //     return $user->role_id === 2 && $user->id === $commande->menu->user_id || $user->role_id === 3

    //         ? Response::allow()
    //         : Response::deny('Vous n\'avez pas les droits pour voir la liste des commandes acceptées.');
    // }

    // public function commandeRefused(User $user, Commande $commande): Response
    // {       
    //     $platcommander= Plat::where('id',$commande->plat_id )->get();
    //     return $user->role_id === 2 && $user->id === $platcommander->menu->user_id || $user->role_id === 3

    //         ? Response::allow()
    //         : Response::deny('Vous n\'avez pas les droits pour voir la liste des commandes refusées.');
    // }
}

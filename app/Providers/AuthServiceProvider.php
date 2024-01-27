<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Avis;
use App\Models\Menu;
use App\Models\Plat;
use App\Models\Role;
use App\Models\Commande;
use App\Models\Categorie;
use App\Policies\AvisPolicy;
use App\Policies\MenuPolicy;
use App\Policies\PlatPolicy;
use App\Policies\RolePolicy;
use App\Policies\CommandePolicy;
use App\Policies\CategoriePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Categorie::class =>CategoriePolicy::class,
        Menu::class =>MenuPolicy::class,
        Plat::class =>PlatPolicy::class,
        Commande::class =>CommandePolicy::class,
        Avis::class =>AvisPolicy::class,
        Role::class =>RolePolicy::class,

    ];

    // protected $policies = [
    //     Article::class => ArticlePolicy::class,
    //     Commentaire::class => CommentairePolicy::class,
    //     User::class => UserPolicy::class,
    //     Chambre::class => ChambrePolicy::class,
    // ];
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}

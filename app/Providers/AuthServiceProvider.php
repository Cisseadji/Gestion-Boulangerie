<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // ---------------------------
        // USERS
        // ---------------------------
        Gate::define('manage-users', fn(User $user) => $user->role === 'ADMIN');

        // ---------------------------
        // PRODUITS
        // ---------------------------
        Gate::define('create-produits', fn(User $user) => in_array($user->role, ['ADMIN']));
        Gate::define('update-produits', fn(User $user) => in_array($user->role, ['ADMIN']));
        Gate::define('view-produits', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE', 'CLIENT']));
        Gate::define('delete-produits', fn(User $user) => $user->role === 'ADMIN');

        // ---------------------------
        // CATEGORIES
        // ---------------------------
        Gate::define('create-categories', fn(User $user) => in_array($user->role, ['ADMIN']));
        Gate::define('update-categories', fn(User $user) => in_array($user->role, ['ADMIN']));
        Gate::define('view-categories', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE', 'CLIENT']));
        Gate::define('delete-categories', fn(User $user) => $user->role === 'ADMIN');

        // ---------------------------
        // COMMANDES
        // ---------------------------
        Gate::define('create-commande', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE', 'CLIENT']));
        Gate::define('update-commande', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE']));
        Gate::define('view-commande', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE', 'CLIENT']));
        Gate::define('delete-commande', fn(User $user) => $user->role === 'ADMIN');
        Gate::define('update-statut-commande', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE']));

        // ---------------------------
        // LIVRAISONS
        // ---------------------------
        Gate::define('update-livraison', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE']));
        Gate::define('view-livraison', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE', 'CLIENT']));

        // ---------------------------
        // PROMOTIONS & PACKS
        // ---------------------------

        Gate::define('create-promotion', fn(User $user) => in_array($user->role, ['ADMIN']));
        Gate::define('update-promotion', fn(User $user) => in_array($user->role, ['ADMIN']));
        Gate::define('view-promotion', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE', 'CLIENT']));
        Gate::define('delete-promotion', fn(User $user) => $user->role === 'ADMIN');
        Gate::define('activate-promotion', fn(User $user) => $user->role === 'ADMIN');


        // PACKS
        Gate::define('create-packs', fn(User $user) => $user->role === 'ADMIN');
        Gate::define('update-packs', fn(User $user) => $user->role === 'ADMIN');
        Gate::define('view-packs', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE', 'CLIENT']));
        Gate::define('delete-packs', fn(User $user) => $user->role === 'ADMIN');


        // ---------------------------
        // SUPPORT CLIENT / CHAT
        // ---------------------------
        Gate::define('use-chat', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE', 'CLIENT']));

        Gate::define('create-pack-produits', fn(User $user) => $user->role === 'ADMIN');
        Gate::define('update-pack-produits', fn(User $user) => $user->role === 'ADMIN');
        Gate::define('view-pack-produits', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE', 'CLIENT']));
        Gate::define('delete-pack-produits', fn(User $user) => $user->role === 'ADMIN');

        Gate::define('create-commande-produits', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE', 'CLIENT']));
        Gate::define('update-commande-produits', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE']));
        Gate::define('view-commande-produits', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE', 'CLIENT']));
        Gate::define('delete-commande-produits', fn(User $user) => $user->role === 'ADMIN');

        Gate::define('create-factures', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE']));
        Gate::define('update-factures', fn(User $user) => $user->role === 'ADMIN');
        Gate::define('view-factures', fn(User $user) => in_array($user->role, ['ADMIN', 'EMPLOYE', 'CLIENT']));
        Gate::define('delete-factures', fn(User $user) => $user->role === 'ADMIN');




    }
}

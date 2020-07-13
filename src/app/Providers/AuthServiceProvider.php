<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        Gate::define('manage-students', function($admin){
            return $admin->hasAnyRoles(['admin','comercial','secretaria']);
        });

        /* Definições de autorizações para /admin/cursos */
        Gate::define('manage-courses', function($admin){
            return $admin->hasAnyRoles(['admin']);
        });

        Gate::define('create-courses', function($admin){
            return $admin->hasAnyRoles(['admin']);
        });

        Gate::define('edit-courses', function($admin){
            return $admin->hasAnyRoles(['admin']);
        });
 

        /* Quem pode criar temas de redação */
        Gate::define('list-themes', function($admin) {
            return $admin->hasAnyRoles(['admin']);
        });

        Gate::define('create-themes', function($admin) {
            return $admin->hasAnyRoles(['admin']);
        });

        Gate::define('edit-themes', function($admin) {
            return $admin->hasAnyRoles(['admin']);
        });

        /* Definição para /admin/usuarios */
        Gate::define('manage-admin', function($admin){
            return $admin->hasRole('admin');
        });

        Gate::define('edit-admin', function($admin){
            return $admin->hasRole('admin');
        });

        Gate::define('create-admin', function($admin){
            return $admin->hasRole('admin');
        });

        /* Definição para /admin/redacoes */
        Gate::define('manage-redacoes', function($admin){
            return $admin->hasAnyRoles(['admin','secretaria']);
        });


        //
    }
}

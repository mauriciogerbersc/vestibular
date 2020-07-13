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

        Gate::define('manage-admin', function($admin){
            return $admin->hasRole('admin');
        });

        Gate::define('edit-admin', function($admin){
            return $admin->hasRole('admin');
        });

        Gate::define('create-admin', function($admin){
            return $admin->hasRole('admin');
        });


        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Automatic Gate Documentation
         *
         * This section of code defines automatic gates for each role present in the application.
         * Gates are used to manage user access permissions based on their roles.
         *
         * Each gate is named with the format 'is' followed by the role name written in CamelCase format.
         * Example: for the role 'administration_admin', the gate will be named 'isAdministrationAdmin'.
         * Ensure the role code is written in snake case.
         *
         * This gate function checks whether the authenticated user has a role that matches
         * the gate being checked. If the user's role code matches the role code defined in the gate,
         * access will be granted.
         *
         * The use of this gate allows developers to easily manage access permissions
         * throughout the application in a structured and organized manner.
         * 
         * The gate will only be executed if the application is running in web mode.
         * 
         * Exception for the role super_admin, super_admin will have all access.
         * 
         * @author: kenndeclouv https://github.com/kenndeclouv https://kenndeclouv.my.id
         * 2025-03-27 
         */
        if (!App::runningInConsole() && Schema::hasTable('roles')) {
            foreach (Role::all() as $role) {
                $gateName = 'is' . str_replace(' ', '', ucwords(str_replace('_', ' ', $role->code)));

                Gate::define($gateName, function ($user) use ($role) {
                    if ($user->roles->contains('code', env('APP_HIGHEST_ROLE', 'super_admin'))) {
                        return true;
                    }
                    return $user->roles->contains('code', $role->code);
                });
            }
        }
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\RoleOrMiddleware
;
use Illuminate\Database\Eloquent\Model;
use App\Services\UserService;


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
    public function boot(Router $router): void
    {
        Model::unguard();
        // For registering middlewares
        $router->aliasMiddleware('role', RoleMiddleware::class);
        $router->aliasMiddleware('role_or', RoleOrMiddleware::class);

        // For registering blade directives 

        // Single role directive
        Blade::if('role', function ($role) {
            return Auth::check() && Auth::user()->hasRole($role);
        });

        // // Multiple roles directive
        Blade::if('roleor', function (...$roles) {
            return Auth::check() && Auth::user()->hasAnyRole($roles);
        }); 


        // Bind the UserService class to the service container
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService();
        });
    }
}

<?php

namespace GilbertRonaldo\CoreSystem\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

/**
 * Class PackageServiceProvider
 * @package GilbertRonaldo\CoreSystem\Providers
 */
class PackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        require __DIR__ . '/../define.php';

        // API ROUTES
        $routeConfig = [
            'namespace' => 'GilbertRonaldo\CoreSystem\Controllers',
            'prefix' => 'auth',
            'domain' => null,
        ];

        $this->getRouter()->group($routeConfig, function($router) {
            $router->post('login', [
                'uses' => 'AuthController@login',
                'as' => 'auth.login',
            ]);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the active router.
     *
     * @return Router
     */
    protected function getRouter()
    {
        return $this->app['router'];
    }
}

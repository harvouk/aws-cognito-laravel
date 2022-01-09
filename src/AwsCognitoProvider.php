<?php

namespace Harvouk\AwsCognitoLaravel;

use Illuminate\Support\ServiceProvider;

class AwsCognitoProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes/web.php';
        $this->app->make('Harvouk\AwsCognitoLaravel\AwsCognitoController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'aws-cognito-laravel');

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/'),
            __DIR__.'/config' => base_path('config'),
            ]
        );

        $this->app['auth']->viaRequest('cognito', function ($request) {
            $jwt = $request->bearerToken();
            $region = config('cognito.region', '');
            $userPoolId = config('cognito.user_pool_id', '');
            if ($jwt) {
                return CognitoJWT::verifyToken($jwt, $region, $userPoolId);
            }
            return null;
        });

    }
}

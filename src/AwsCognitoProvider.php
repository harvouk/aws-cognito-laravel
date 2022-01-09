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
        include __DIR__.'/routes/auth.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            Console\InstallCommand::class,
        ]);

        $this->publishes([
                __DIR__.'/routes' => base_path('routes/'),
            ]
        );
    }
}

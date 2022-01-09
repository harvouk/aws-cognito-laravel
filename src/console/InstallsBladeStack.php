<?php

namespace Harvouk\AwsCognitoLaravel\Console;

use Illuminate\Filesystem\Filesystem;

trait InstallsBladeStack
{
    /**
     * Install the Blade Breeze stack.
     *
     * @return void
     */
    protected function installBladeStack()
    {

        // Controllers...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers/Auth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/App/Http/Controllers/Auth', app_path('Http/Controllers/Auth'));

        // Requests...
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests/Auth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/App/Http/Requests/Auth', app_path('Http/Requests/Auth'));

        // Models...
        (new Filesystem)->ensureDirectoryExists(app_path('Models'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/App/Models', app_path('Models'));

        // Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));

        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/resources/views/auth', resource_path('views/auth'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/resources/views/layouts', resource_path('views/layouts'));

//        copy(__DIR__.'/../../stubs/default/resources/views/dashboard.blade.php', resource_path('views/dashboard.blade.php'));

        // Components...
//        (new Filesystem)->ensureDirectoryExists(app_path('View/Components'));
//        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/App/View/Components', app_path('View/Components'));

        // Tests...
        $this->installTests();

        // Routes...
        //copy(__DIR__ . '/../../stubs/default/routes/auth.php', base_path('routes/web.php'));
        //copy(__DIR__.'/../../stubs/default/routes/auth.php', base_path('routes/auth.php'));

        // "Dashboard" Route...
        //$this->replaceInFile('/home', '/dashboard', resource_path('views/welcome.blade.php'));
        //$this->replaceInFile('Home', 'Dashboard', resource_path('views/welcome.blade.php'));
        //$this->replaceInFile('/home', '/dashboard', app_path('Providers/RouteServiceProvider.php'));

        // Tailwind / Webpack...
        //copy(__DIR__.'/../../stubs/default/tailwind.config.js', base_path('tailwind.config.js'));
        //copy(__DIR__.'/../../stubs/default/webpack.mix.js', base_path('webpack.mix.js'));
        //copy(__DIR__.'/../../stubs/default/resources/css/app.css', resource_path('css/app.css'));
        //copy(__DIR__.'/../../stubs/default/resources/js/app.js', resource_path('js/app.js'));


        copy(__DIR__.'/../../stubs/default/config/cognito.php', base_path('config/cognito.php'));

        copy(__DIR__.'/../../stubs/default/resources/css/auth.css', resource_path('css/auth.css'));

        $this->info('Cognito scaffolding installed successfully.');
        $this->comment('Navigate to /cognito to get started');
    }
}

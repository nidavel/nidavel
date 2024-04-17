<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BlastaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        require_once base_path('/app/Blasta/GlobalVars.php');
        require_once base_path('/app/Blasta/Functions/blastaGlobalFunctions.php');
        require_once base_path('/app/Blasta/Classes/blastaGlobalClasses.php');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->prefix('posts')
                ->group(base_path('routes/posts.php'));
            
            Route::middleware('web')
                ->prefix('pages')
                ->group(base_path('routes/pages.php'));

            Route::middleware('web')
                ->prefix('dashboard')
                ->group(base_path('routes/dashboard.php'));

            Route::middleware('web')
                ->prefix('appearance')
                ->group(base_path('routes/appearance.php'));
            
            Route::middleware('web')
                ->prefix('menu')
                ->group(base_path('routes/menu.php'));

            Route::middleware('web')
                ->prefix('plugins')
                ->group(base_path('routes/plugins.php'));

            Route::middleware('web')
                ->prefix('settings')
                ->group(base_path('routes/settings.php'));

            Route::middleware('web')
                ->prefix('themes')
                ->group(base_path('routes/themes.php'));

            Route::middleware('web')
                ->prefix('widgets')
                ->group(base_path('routes/widgets.php'));

            Route::middleware('web')
                ->prefix('exports')
                ->group(base_path('routes/exports.php'));

            Route::middleware('web')
                ->prefix('media')
                ->group(base_path('routes/media.php'));
            
            Route::middleware('web')
                ->prefix('upload')
                ->group(base_path('routes/upload.php'));
        });
    }
}

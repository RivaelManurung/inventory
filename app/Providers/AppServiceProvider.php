<?php

// app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\DynamicRoleMiddleware;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app['router']->aliasMiddleware('dynamic.role', DynamicRoleMiddleware::class);
        
        // Define middleware groups
        $this->app['router']->middlewareGroup('api', [
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    }
}
<?php

namespace WebModularity\LaravelProviders;

use Illuminate\Support\ServiceProvider;

class ProvidersServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Config
        $this->mergeConfigFrom(__DIR__ . '/../config/providers.php', 'wm.providers');
    }

    public function boot() {
        // Config
        $this->publishes([__DIR__ . '/../config/providers.php' => config_path('wm/providers.php')], 'config');
    }
}
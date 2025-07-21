<?php

namespace Jjacobstech\Roqqu;

use Illuminate\Support\ServiceProvider;

class RoqquServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/roqqu.php' => config_path('roqqu.php'),
        ], 'roqqu-config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/roqqu.php',
            'roqqu'
        );
    }
}

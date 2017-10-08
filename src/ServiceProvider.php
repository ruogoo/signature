<?php
/**
 * This file is part of ruogoo.
 *
 * Created by HyanCat.
 *
 * Copyright (C) HyanCat. All rights reserved.
 */

namespace Ruogoo\Signature;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Ruogoo\Signature\Console\ClientGenerate;
use Ruogoo\Signature\Console\ClientRevoke;
use Ruogoo\Signature\Middleware\Signature;

class ServiceProvider extends IlluminateServiceProvider
{
    protected $defer = true;

    public function register(): void
    {
        $this->app['router']->aliasMiddleware('signature', Signature::class);

        $this->app->bind(SignatureInterface::class, function () {
            return new SignatureValidation();
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {

            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
            $this->publishes([
                __DIR__ . '/../database/migrations/' => database_path('migrations'),
            ], 'migrations');

            $this->publishes([
                __DIR__ . '/../config/signature.php' => config_path('signature.php'),
            ], 'config');

            $this->commands([
                ClientGenerate::class,
                ClientRevoke::class,
            ]);
        }
    }
}

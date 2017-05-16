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

class ServiceProvider extends IlluminateServiceProvider
{
    public function register()
    {
        $this->app->bind(SignatureInterface::class, function () {
            return new SignatureValidation();
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
            $this->publishes([
                __DIR__ . '/../database/migrations/' => database_path('migrations'),
            ], 'migrations');

            $this->commands([
                ClientGenerate::class,
                ClientRevoke::class,
            ]);
        }
    }
}

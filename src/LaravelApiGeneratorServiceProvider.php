<?php

namespace UzInfo\LaravelApiGenerator;

use Illuminate\Support\ServiceProvider;
use UzInfo\LaravelApiGenerator\Commands\Bread;
use UzInfo\LaravelApiGenerator\Commands\MakeControllerApi;
use UzInfo\LaravelApiGenerator\Commands\MakeMigrationApi;
use UzInfo\LaravelApiGenerator\Commands\MakeModelApi;
use UzInfo\LaravelApiGenerator\Commands\MakeRepositoryApi;
use UzInfo\LaravelApiGenerator\Commands\MakeRequestApi;
use UzInfo\LaravelApiGenerator\Commands\MakeResourceApi;
use UzInfo\LaravelApiGenerator\Commands\MakeResourceListApi;
use UzInfo\LaravelApiGenerator\Commands\MakeServiceApi;

class LaravelApiGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        // Publish stubs
        $this->publishes([
            __DIR__ . '/Stubs' => base_path('stubs'),
        ], 'api-generator-stubs');

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                Bread::class,
                MakeControllerApi::class,
                MakeMigrationApi::class,
                MakeModelApi::class,
                MakeRepositoryApi::class,
                MakeRequestApi::class,
                MakeResourceApi::class,
                MakeResourceListApi::class,
                MakeServiceApi::class,
            ]);
        }
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        // Register package services if needed
    }
}

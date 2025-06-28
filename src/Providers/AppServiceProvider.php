<?php

namespace Innoboxrr\S3ResumableUploads\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/s3resumableuploads.php', 's3resumableuploads');
    }

    public function boot()
    {
        
        // $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // $this->loadViewsFrom(__DIR__.'/../../resources/views', 's3resumableuploads');

        if ($this->app->runningInConsole()) {
            
            // $this->publishes([__DIR__.'/../../resources/views' => resource_path('views/vendor/s3resumableuploads'),], 'views');

            $this->publishes([__DIR__.'/../../config/s3resumableuploads.php' => config_path('s3resumableuploads.php')], 'config');

        }

    }
    
}
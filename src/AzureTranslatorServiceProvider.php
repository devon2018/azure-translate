<?php

namespace Devonray\AzureTranslate;

use Illuminate\Support\ServiceProvider;
use Devonray\AzureTranslate\Console\Commands\Translate;
use Illuminate\Foundation\AliasLoader;


class AzureTranslatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the translation package.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->register(\Ixudra\Curl\CurlServiceProvider::class); // Register Curl

        $this->app->alias('Curl', Ixudra\Curl\Facades\Curl::class); // Create Curl Alias

        $this->app->configure('language'); // Load language config

        // Register the terminal Command
        if ($this->app->runningInConsole()) {
            $this->commands([
                Translate::class,
            ]);
        }

        // Publish the language config file to config folder
        $this->publishes([
            __DIR__.'/config/language.php' => config_path('language.php'),
        ]);
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

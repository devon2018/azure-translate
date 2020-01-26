<?php

namespace Devonray\AzureTranslate;

use Illuminate\Support\ServiceProvider;
use Devonray\AzureTranslate\Console\Commands\Translate;
use Illuminate\Foundation\AliasLoader;
use Ixudra\Curl\Facades\Curl;

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

        $this->app->alias('Curl', Curl::class); // Create Curl Alias

        
        if (app() instanceof \Illuminate\Foundation\Application) {
          // Laravel
        } else {
          die('works');
          $this->app->configure('language'); // Load language config
            // Lumen
        }

        // Register the terminal Command
        if ($this->app->runningInConsole()) {
            $this->commands([
                Translate::class,
            ]);
        }
        
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

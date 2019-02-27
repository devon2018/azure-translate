# Lumen Azure translate

azure translation artisan command for laravel/lumen



add provider 

$app->register(Devonray\AzureTranslate\AzureTranslatorServiceProvider::class);


create a storage option

  'local_r' => [
            'driver' => 'local',
            'root' => base_path()
        ],

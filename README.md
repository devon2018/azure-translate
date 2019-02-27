# Lumen Azure translation package


### Installation

This package requires lumens local file storage to be setup
[How to setup lumen local strage](https://github.com/devon2018/add-localstorage-to-lumen)

```cli
    composer require devonray/azuretranslate
```

Add the following to your bootstrap/app.php file to register the service provider

```php
    $app->register(Devonray\AzureTranslate\AzureTranslatorServiceProvider::class);
```

Copy the language file into your config/ directory

add your Azure api key to your enviroment file

```env
  AZURE_KEY=secret
```

add a new storage option to your filesystems.php

```php
  'local_r' => [
    'driver' => 'local',
    'root' => base_path()
  ],
```

##### !important Make sure the resources/lang/ directory exists


# Usage
You can use the packge from the terminal like follows 
```cli
    php artisan translation:create "translation.key" "String to translate"
```


Adding the "." in the name will split the translations into files e.g user.name will
create a line in the user.php translation with the name key

If no "." are present in the string then they get put into the main.php file
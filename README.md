# Factotum
Factotum is a Laravel-based open source CMS, that follow a simple rule:
_We love KISSing the DRY PIE_.

### Installation

1. Install a fresh laravel application and configure your .env file with the database keys.
```
laravel new [project name]
```

2. Remove the default migrations and user model created by the previous command
```
[project_path]/database/migrations
[project_path]/database/seeds/DatabaseSeeder.php
[project_path]/app/User.php
```

3. Install wia composer:
```
composer require kaleidoscope/factotum
```

4. And add these services providers in config/app.php:
```php
'providers' => [
    ...
    Intervention\Image\ImageServiceProvider::class,
    Barryvdh\Debugbar\ServiceProvider::class,
    Kaleidoscope\Factotum\FactotumServiceProvider::class,
    ...
]
```

Then register Facade class aliases:

```php
'aliases' => [
    ...
    'Image'                       => Intervention\Image\Facades\Image::class,
    'PrintContentsTree'           => Kaleidoscope\Factotum\Helpers\PrintContentsTreeHelper::class,
    'PrintCategoriesTree'         => Kaleidoscope\Factotum\Helpers\PrintCategoriesTreeHelper::class,
    'PrintContentsDropdownTree'   => Kaleidoscope\Factotum\Helpers\PrintContentsDropdownTreeHelper::class,
    'PrintCategoriesDropdownTree' => Kaleidoscope\Factotum\Helpers\PrintCategoriesDropdownTreeHelper::class,
    'PrintMenu'                   => Kaleidoscope\Factotum\Helpers\PrintMenuHelper::class,
    'PrintCategories'             => Kaleidoscope\Factotum\Helpers\PrintCategoriesHelper::class,
    'PrintField'                  => Kaleidoscope\Factotum\Helpers\PrintFieldHelper::class,
    ...
]
```

5. Launch the installation process:
```
php artisan factotum:install
```

_Note: pay attention to the default laravel folders permissions (storage and bootstrap folders)_

ENJOY FACTOTUM!!

You can find the full documentation here: [Factotum documentation](https://factotum.kaleidoscope.it/docs) .


## Contributing

Thank you for considering contributing to Factotum!

## Security Vulnerabilities

If you discover a security vulnerability within Factotum, please send an e-mail to Filippo Matteo Riggio at filippo@kaleidoscope.it. All security vulnerabilities will be promptly addressed.

## License

The Factotum CMS is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
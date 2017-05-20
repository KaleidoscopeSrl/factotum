# Factotum
Factotum is a Laravel-based open source CMS, that follow a simple rule:
_We love KISSing the DRY PIE_.

### Installation

Install wia composer:
```
composer require kaleidoscope/factotum
```
And add these services providers in config/app.php:
```php
Intervention\Image\ImageServiceProvider::class,
Barryvdh\Debugbar\ServiceProvider::class,
Kaleidoscope\Factotum\FactotumServiceProvider::class,
```

Then register Facade class aliases:

```php
'Image'                       => Intervention\Image\Facades\Image::class,
'PrintContentsTree'           => Kaleidoscope\Factotum\Helpers\PrintContentsTreeHelper::class,
'PrintCategoriesTree'         => Kaleidoscope\Factotum\Helpers\PrintCategoriesTreeHelper::class,
'PrintContentsDropdownTree'   => Kaleidoscope\Factotum\Helpers\PrintContentsDropdownTreeHelper::class,
'PrintCategoriesDropdownTree' => Kaleidoscope\Factotum\Helpers\PrintCategoriesDropdownTreeHelper::class,
'PrintMenu'                   => Kaleidoscope\Factotum\Helpers\PrintMenuHelper::class,
'PrintCategories'             => Kaleidoscope\Factotum\Helpers\PrintCategoriesHelper::class,
'PrintField'=> Kaleidoscope\Factotum\Helpers\PrintFieldHelper::class,
```

Publish CMS parts:
```
php artisan vendor:publish
```

Run database migrations and seeding:
```
php artisan migrate
php artisan db:seed
```

You can find the full documentation here: [Factotum documentation](https://factotum.kaleidoscope.it/docs) .


## Contributing

Thank you for considering contributing to Factotum!

## Security Vulnerabilities

If you discover a security vulnerability within Factotum, please send an e-mail to Filippo Matteo Riggio at filippo@kaleidoscope.it. All security vulnerabilities will be promptly addressed.

## License

The Factotum CMS is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
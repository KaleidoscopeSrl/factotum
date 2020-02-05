# Factotum 4
Factotum is a Laravel-based open source CMS, that follow a simple rule:
_We love KISSing the DRY PIE_.

### Laravel Setup

1. Install a fresh Laravel application and **configure your .env file** with the database keys.
```
laravel new [project name]
```
2. Set your web server document root to the **public** folder

_Attention!!_ 
Be sure that the **bootstrap/cache** folder 
and the **storage** folder are writable by the web server


4. Set the Laravel Application Key
```
php artisan key:generate
```

### Factotum Setup

1. Install **factotum** wia composer:
```
composer require kaleidoscope/factotum
```

3. And add these services providers in **config/app.php**:

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
    'PrintMenu'                   => Kaleidoscope\Factotum\Helpers\PrintMenuHelper::class,
    'PrintCategories'             => Kaleidoscope\Factotum\Helpers\PrintCategoriesHelper::class,
    'PrintField'                  => Kaleidoscope\Factotum\Helpers\PrintFieldHelper::class,
    ...
]
```

3. Launch the install:
```
php artisan factotum:install
```


ENJOY FACTOTUM

You can find the full documentation here: [Factotum documentation](https://factotum.kaleidoscope.it/docs) .


### Changing Version from Factotum 1.3 to Factotum 4

1. Change the version in the composer.json from 1.3 to 4.0.0

2. Run these commands:
```
composer update
php artisan vendor:publish --tag=passport-migrations
php artisan migrate
php artisan passport:install

```

3. In vendor/kaleidoscope/factotum/FactotumServiceProvider.php comment out these lines:

```php
// __DIR__ . '/public/assets'            => public_path('assets'),
// __DIR__ . '/resources/views/frontend' => resource_path( 'views/frontend' )
```
then run
```
php artisan vendor:publish --tag=factotum
```

4. Rename "content_categories" table to "category_content".

5. Remove "manage_categories" from the "roles" table

### Content Migration from Factotum 1.3 to Factotum 4

1. Make a backup copy of your current database

2. Create a new database where the new Factotum will be migrated

3. Configure the .env variables for the new database:

```
DB_CONNECTION=mysql
DB_HOST=[new database host]
DB_PORT=[new database port]
DB_DATABASE=[new database name]
DB_USERNAME=[new database username]
DB_PASSWORD=[new database password]
```

4. Configure the .env variables for the previous database:

```
OLD_DB_CONNECTION=old_fm
DB_HOST=[previous database host]
DB_PORT=[previous database port]
DB_DATABASE=[previous database name]
DB_USERNAME=[previous database username]
DB_PASSWORD=[previous database password]
```

5. To migrate existing content types and content fields, run:

```
factotum:migrate-content-type-fields {slug of the Content Type}
```

6. To migrate existing media run:

```
factotum:migrate-media
```

7. To migrate existing contents, run:

```
factotum:migrate-content-type-fields {slug of the Content Type}
```


## Contributing

Thank you for considering contributing to Factotum!

## Security Vulnerabilities

If you discover a security vulnerability within Factotum, please send an e-mail to Filippo Matteo Riggio at filippo@kaleidoscope.it. All security vulnerabilities will be promptly addressed.

## License

The Factotum CMS is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
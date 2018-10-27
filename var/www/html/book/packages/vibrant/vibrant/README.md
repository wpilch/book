# Vibrant Laravel Components Package

## Requirements

* Laravel ^5.6.4 
* php ~7.1
* The package uses '/backend' as prefix for all its routes, so it should be available
* Tested on Linux Ubuntu 16.04

## Installation

Step 1. Get a fresh install of Laravel or work in a currently installed one.

Step 2. Create the `packages/vibrant` folders at the root directory of your Laravel app and copy 
the `vibrant` folder of this package inside the new directory. Doing this you will have now the following tree: 
`packages/vibrant/vibrant/src`. We repeat the `vibrant` folder just to be ready for future packages.

Step 3. Edit your `composer.json` main file to be able to get the package from the repository we just created.

```json
{
    ...
    "repositories": [
        {
            "type": "path",
            "url": "packages/*/*"
        }
    ],
    "minimum-stability": "dev",
    "prefer-stable": true,
    ...
}
```

Step 4. In the same `composer.json` file, add the line `vibrant/vibrant: "*"` at the end of the  `require` section:
```json
{
    ...
    "require": {
        ...
        "vibrant/vibrant": "*"
    },
    ...
}
```

Step 5. Run `composer update` to get the packaged installed automatically.

Step 6. Publish the public assets by running:  
`php artisan vendor:publish --tag=vibrant_components_public_assets` 

Step 7. Publish the config file by running : 
`php artisan vendor:publish --tag=vibrant_components_config` 

Step 8. Migrate and seed the dummy table to get the examples with data. The example table name is `fake_subscribers`.  
   * Migrate the table:  
`php artisan migrate --path=/packages/vibrant/vibrant/src/migrations`
 
   * Seed the data (it may take a couple of minutes):  
`php artisan db:seed --class="Vibrant\Vibrant\Seeders\FakeSubscribersTableSeeder"`

Final tip: If want to work with special middleware other than 'web' and ‘auth’, go to the `vibrant` config file and make the proper changes to 
the `add_route_groups` parameter. For example, if your app does not implement Laravel's users login you can do:
```php
    'add_route_groups' => [
        // 'middleware' => ['web', 'auth']
        'middleware' => ['web']
    ]
```
**We are done!** Go to the [Package URL](/backend) [http://yourApp/backend]

## Authors

* **Edgar Escudero** - eescudero@aerobit.com

This product includes original and copyrighted code developed at Aerobit, SA de CV.

## License

See the license file included in this folder. 


<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Route Groups
    |--------------------------------------------------------------------------
    |
    | Here you can provide additional middleware to the package route group.
    |
    */
    'add_route_groups' => [
        'middleware' => ['web', 'auth']
    ],

    /*
    |--------------------------------------------------------------------------
    | Components Blade Path
    |--------------------------------------------------------------------------
    |
    | This is an array with the paths info of your own components. First element's key is 'folder_path'
    | with the absolute path of the folder as value. Second element's key is 'blade_path_prefix'
    | with a valid blade path prefix.
    |
    */

    'custom_components_paths' => [
        [
            'folder_path' => resource_path('views/components'),
            'blade_path_prefix' => 'components'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Bring Imports Blade Path
    |--------------------------------------------------------------------------
    |
    | This is the blade path for your own imports folder. It has to be
    | a valid blade's views prefix.
    |
    */

    'bring_imports_blade_path' => env('BRING_IMPORTS_BLADE_PATH', 'imports')
];


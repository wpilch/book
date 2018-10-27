# How to update package versions?
 - Do a backup of your app.
 - Mind the changes documented in this log; identify if/where you will need to apply changes in your app.
 - Replace all the files in `vibrant/vibrant` directory for the ones in this package.
 - (If needed) Republish the public assets by running:  
 `php artisan vendor:publish --tag=vibrant_components_public_assets --force` 
 - (If needed) Republish the config file by running: 
 `php artisan vendor:publish --tag=vibrant_components_config --force` 
 - Make sure your `composer.json` file calls the required version (i.e. "vibrant/vibrant": "*")
 - Run `composer update`.
 - The installed version of the package will show in its card at the Backend Home.

## Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [1.2.0] - 2018-08-28
### Added
 - vibTable: Appended attributes are now supported
 - vibForm: Select2 input with live search and grouped options added
 - vibForm: Checkbox and Switch have now 'label_position' parameter to configure the position of label (left, right or top) 
 - vibForm: Text and Password inputs now support pattern validation
 - vibForm: Switch inputs include now parameters for submitted value, on/off labels, and on/off colors
 - vibForm: Automatic validation for password confirmation
 - Express CRUD: Validation rules now can be defined for each request method individually
 - Express CRUD: Pre-action and Post-action hook methods can be called for custom CRUD action processing
 - Express CRUD: 'crud_only_for' parameter can now be used in the fields array to indicate that a field should be shown exclusively for certain crud action (i.e. 'password' => [ ... 'crud_only_for' => 'create']) 
 - General fixes on styles
 
### Fixed
 - vibTable: There was a bug when tables are set with empty order_by or order_direction parameters, now it takes 'updated_at' and 'desc' as default values
 - vibTable: The 'create' button was shown even if the 'include_create_btn' parameter was set to false
 - vibForm: Select input was not validated when empty
 - Express CRUD: 'crud_exclude' had a bug 

 
## [1.1.0] - 2018-08-13
### Added
 - Components: Textarea input added
 - vibForm: 'crud_exclude' parameter can now be used in the fields array to indicate that a field should be excluded from certain crud action (i.e. 'status' => [ ... 'crud_exclude' => 'create']) 
 - vibTable: has now configurable sort_by and order_direction parameters
 - Express CRUD: nested resources are now supported 
 
### Changed
 - BlueFlame UI: 'right-to-left' default animation for dropdown menus was removed
 - vibForm: 'read_only' parameter had a typo in the name (it was 'ready_only')
 
### Fixed
 - Minor errors in Readme/HowToInstall
 - Web routes did not accept middleware changes from the config file
 - vibTable: showed filter icon even when filter array is empty
 - vibForm: ajax submit had a bug that prevented proper functionality

## [1.0.0] - 2018-07-14
### Added
 - Initial Release

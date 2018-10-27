<?php

use Illuminate\Support\Facades\Route;

$route_groups = config('vibrant.add_route_groups');

if(empty($route_groups) || !is_array($route_groups)){
    $route_groups = [];
}

Route::group(array_merge(['prefix' => 'backend', 'as' => 'backend.', 'middleware' => 'web'], $route_groups) , function () {

    Route::namespace('Vibrant\Vibrant\Controllers')->group(function () {
        /**
         * Dashboard or Home
         */
        Route::get('/', 'DashboardController@index');
        Route::get('/home', 'DashboardController@index')->name('home');
        /**
         * Reusable components module
         */
        Route::get('/components', 'ComponentsController@index')->name('components');
        Route::get('/components/getComponentInfo', 'ComponentsController@getComponentInfo')->name('components.getInfo');
        Route::get('/components/preview', 'ComponentsController@preview')->name('components.preview');
        Route::any('/components/catchRequest', 'ComponentsController@catchRequest');
        /**
         * Cookies
         */
        //Set cookie via ajax
        Route::post('cookies/set', 'CookiesController@setCookie')->name('cookies.set');
        /**
         *  Tools
         */
        Route::get('tools/getRandomPassword', 'ToolsController@getRandomPassword')->name('tools.getRandomPassword');
    });

    /**
     * Examples and Docs
     */
    Route::namespace('Vibrant\Vibrant\Examples')->group(function ()  {

        Route::crud('examples/crud', 'FakeSubscribersController');

        Route::view('docs/addComponent', 'vibrant::docs.addComponent', ['module_name' => 'add_components'])->name('docs.add_components');
        Route::view('docs/mcvExample', 'vibrant::docs.mcvExample', ['module_name' => 'mcv_example'])->name('docs.mcv_example');
        Route::view('docs/viewTools', 'vibrant::docs.viewTools', ['module_name' => 'view_tools'])->name('docs.view_tools');

    });


});


Route::group(['prefix' => 'backend', 'as' => 'backend.'] , function () {
    /**
     * Php Info
     * Delete this if not useful
     **/
    Route::get('/phpinfo', function(){
        dd(phpinfo());
    });
});

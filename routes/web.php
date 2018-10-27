<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@home');
Route::get('/person/create', 'HomeController@create');
Route::get('/dodaj', 'HomeController@create');
Route::post('/person/store', 'HomeController@store');
Auth::routes();

Route::crud('/backend/home/crud', 'HomeController');
Route::crud('/backend/persons/crud', 'PersonsController');
Route::post('/backend/person/crud/accept/{id}', 'PersonsController@accept');
Route::post('/backend/person/crud/bulkAccept', 'PersonsController@bulkAccept');

Route::crud('/admin', 'PersonsController');
Route::post('/backend/person/crud/accept/{id}', 'PersonsController@accept');
Route::post('/backend/person/crud/bulkAccept', 'PersonsController@bulkAccept');


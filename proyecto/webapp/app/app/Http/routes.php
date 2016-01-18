<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return Redirect::to('/cliente');
});

Route::get('/auth/login', 'Auth\AuthController@getLogin');
Route::post('/auth/login', 'Auth\AuthController@postLogin');

Route::get('/cliente', ['middleware' => 'auth', 'uses' => 'ClienteController@all']);

Route::get('/cliente/view/{id}', ['middleware' => 'auth', 'uses' => 'ClienteController@view'])->where(['id' => '^[\d]+$']);

Route::get('/cliente/add', ['middleware' => 'auth', 'uses' => 'ClienteController@add']);
Route::post('/cliente/add', ['middleware' => 'auth', 'uses' => 'ClienteController@create']);

Route::get('/cliente/edit/{id}', ['middleware' => 'auth', 'uses' => 'ClienteController@edit'])->where(['id' => '^[\d]+$']);
Route::post('/cliente/edit/{id}', ['middleware' => 'auth', 'uses' => 'ClienteController@update'])->where(['id' => '^[\d]+$']);

Route::get('/cliente/envio/{id}', ['middleware' => 'auth', 'uses' => 'ClienteController@envio'])->where(['id' => '^[\d]+$']);
Route::get('/cliente/envio/{cliente}/info/{envio}', ['middleware' => 'auth', 'uses' => 'ClienteController@envioInfo'])->where(['cliente' => '^[\d]+$', 'envio' => '^[\d]+$']);

Route::get('/cliente/envio/{cliente}/add', ['middleware' => 'auth', 'uses' => 'ClienteController@envioAdd'])->where(['cliente' => '^[\d]+$']);
Route::post('/cliente/envio/{cliente}/add', ['middleware' => 'auth', 'uses' => 'ClienteController@envioCreate'])->where(['cliente' => '^[\d]+$']);

Route::get('/envio', ['middleware' => 'auth', 'uses' => 'EnvioController@all']);
Route::get('/envio/add', ['middleware' => 'auth', 'uses' => 'EnvioController@add']);
Route::post('/envio/add', ['middleware' => 'auth', 'uses' => 'EnvioController@create']);
Route::get('/envio/view/{id}', ['middleware' => 'auth', 'uses' => 'EnvioController@view'])->where(['id' => '^[\d]+$']);
Route::get('/envio/qr/{id}', ['middleware' => 'auth', 'uses' => 'EnvioController@qr'])->where(['id' => '^[\d]+$']);
Route::get('/envio/edit/{id}', ['middleware' => 'auth', 'uses' => 'EnvioController@edit'])->where(['id' => '^[\d]+$']);
Route::post('/envio/edit/{id}', ['middleware' => 'auth', 'uses' => 'EnvioController@update'])->where(['id' => '^[\d]+$']);

Route::get('/transportista', ['middleware' => 'auth', 'uses' => 'TransportistaController@all']);
Route::get('/transportista/add', ['middleware' => 'auth', 'uses' => 'TransportistaController@add']);
Route::post('/transportista/add', ['middleware' => 'auth', 'uses' => 'TransportistaController@create']);
Route::get('/transportista/envio/{id}', ['middleware' => 'auth', 'uses' => 'TransportistaController@envio'])->where(['id' => '^[\d]+$']);
Route::get('/transportista/envio/{id}/info/{envio}', ['middleware' => 'auth', 'uses' => 'TransportistaController@envioInfo'])->where(['id' => '^[\d]+$', 'envio' => '^[\d]+$']);
Route::get('/transportista/view/{id}', ['middleware' => 'auth', 'uses' => 'TransportistaController@view'])->where(['id' => '^[\d]+$']);
Route::get('/transportista/edit/{id}', ['middleware' => 'auth', 'uses' => 'TransportistaController@edit'])->where(['id' => '^[\d]+$']);
Route::post('/transportista/edit/{id}', ['middleware' => 'auth', 'uses' => 'TransportistaController@update'])->where(['id' => '^[\d]+$']);

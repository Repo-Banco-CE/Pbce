<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', [
    'uses'	=>	'OperacionesController@consulta_http',
    'as'	=>	'consulta_http'
]);


Route::get('/prueba', function() {
    return "result http";
});



Route::post('/pagocontarjeta',[

	'middleware' => ['api', 'cors'],
	'uses'	=>	'OperacionesController@pagocontarjeta',
	'as'	=>	'operaciones.pagocontarjeta'

	]);   


Route::post('/login', [

	'middleware' => ['api', 'cors'],
	'uses'	=> 'OperacionesController@login',
	'as'	=> 'api-login'
	]);

Route::post('/enviarfactura',[

	'middleware' => ['api', 'cors'],
	'uses'	=>	'FacturasController@factura_create',
	'as'	=>	'factura.create'
	]);

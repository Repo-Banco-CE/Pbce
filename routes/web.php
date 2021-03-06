<?php
use App\Cuenta;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/',['as' => 'admin.welcome', function () {
    return view('welcome');
}]);


Route::group(['prefix' =>'admin', 'middleware' => 'auth'],function(){
//Route::group(['prefix' =>'admin'],function(){
	
	Route::resource('users','UsersController');
	Route::get('users/{id}/destroy',[
		'uses' => 'UsersController@destroy',
		'as' => 'admin.users.destroy'
		]);
	Route::resource('cuentas','CuentasController');

	Route::get('cuenta/pagartarjeta', ['as'	=>	'cuenta.pagar-tarjeta' ,function(){

		$cuentas= Cuenta::all();
		return view('admin.cuentas.pagar-tarjeta')->with('cuentas',$cuentas);
	}]);

	Route::post('cuenta/pagartarjeta', [
		'uses'	=> 'CuentasController@pagartarjeta',
		'as'	=>	'postcuenta.pagar-tarjeta' 
	]);

	Route::get('cuenta/afiliacion', ['as'	=>	'cuenta.afiliacion' ,function(){

		$cuentas= Cuenta::all();
		return view('admin.cuentas.afiliacion-comercial')->with('cuentas',$cuentas);
	}]);

	Route::get('cuenta/{id}/afiliar', [

		'uses'	=>	'CuentasController@afiliar',
		'as'	=>	'cuenta.afiliar' 
	]);

	Route::get('cuenta/{id}/retirar', [

		'uses'	=>	'CuentasController@retirarse',
		'as'	=>	'cuenta.retirar' 
	]);

	Route::get('cuenta/movimientos', [

		'uses'	=>	'MovimientosController@index',
		'as'	=>	'cuenta.movimientos' 
	]);

	Route::get('cuenta/movimientos/tarjeta', [

		'uses'	=>	'MovimientosController@tarjeta',
		'as'	=>	'cuenta.movimientos.tarjeta' 
	]);

	Route::get('cuenta/transferencia', ['as'	=>	'cuenta.transferencia' ,function(){

		$cuentas= Cuenta::all();
		return view('admin.cuentas.transferencia')->with('cuentas',$cuentas);
	}]);

	Route::post('cuenta/transferencia', [

			'uses'	=>	'CuentasController@transferencia',
			'as'	=>	'cuenta.posttransferencia' 

			]);

	Route::resource('juridicas','JuridicasController');

	Route::resource('cuentas_usuarios','Cuentas_UsuariosController');

########################################################################################
#						Información de Facturas por Cobrar 							   #
########################################################################################
#
	Route::get('/facturas/activas',[

	'uses'	=>	'FacturasController@facturas_activas',
	'as'	=>	'facturas.activas'
	]);

	Route::get('/facturas/pagadas',[

	'uses'	=>	'FacturasController@facturas_pagadas',
	'as'	=>	'facturas.pagadas'
	]);

	Route::get('/facturas/vencidas',[

	'uses'	=>	'FacturasController@facturas_vencidas',
	'as'	=>	'facturas.vencidas'
	]);

########################################################################################
#						Información de Facturas por Pagar 							   #
########################################################################################
	Route::get('/pagarfacturas/activas',[

	'uses'	=>	'FacturasController@pagarfacturas_activas',
	'as'	=>	'pagarfacturas.activas'
	]);

	Route::get('/pagarfacturas/pagadas',[

	'uses'	=>	'FacturasController@pagarfacturas_pagadas',
	'as'	=>	'pagarfacturas.pagadas'
	]);

	Route::get('/pagarfacturas/vencidas',[

	'uses'	=>	'FacturasController@pagarfacturas_vencidas',
	'as'	=>	'pagarfacturas.vencidas'
	]);

	Route::get('factura/{id}/pagar', [

		'uses'	=>	'FacturasController@pagarfactura',
		'as'	=>	'pagar.factura' 
	]);

});

//EL FORMATO DEL 'as' TIENE LA RUTA DEL ARCHIVO QUE SE VA A EJECUTAR
//PARA LLAMAR A UNA VISTA SE USA EL NOMBRE DE LA RUTA

########################################################################################
#			Registro para usuarios naturales y juridicos							   #
########################################################################################

Route::get('admin/users/create/natural',['as'	=>	'admin.user.create-natural'	,function(){

	return view('admin.users.create-natural');
}]);



Route::get('admin/users/create/juridico', ['as'	=>	'admin.user.create-juridico', function(){

	return view('admin.users.create-juridico');
}]);

Route::post('admin/users/store/juridico', [
		'uses'	=>	'UsersController@store',
		'as'	=>	'admin.users.store-juridico'		
]);

########################################################################################
#									Login							                   #
########################################################################################

Route::get('admin/auth/login', [
		'uses'	=>	'Auth\LoginController@Login',
		'as'	=>	'admin.auth.login'		
	]);

Route::get('admin/auth/login-juridico', [ 'as'	=>	'admin.auth.login-juridico', function(){

	return view('admin.auth.login-juridico');
}]);

Route::post('admin/auth/login', [
		'uses'	=>	'Auth\LoginController@postLogin',
		'as'	=>	'admin.auth.postlogin'
	]);

Route::get('admin/auth/logout', [
		'uses'	=>	'Auth\LoginController@logout',
		'as'	=>	'admin.auth.logout'
	]);

########################################################################################
#								Manejo de Errores					                   #
########################################################################################

Route::get('/error',function() {
   abort(404) ;
});
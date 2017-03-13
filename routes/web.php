<?php

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

	Route::resource('juridicas','JuridicasController');

	Route::resource('cuentas_usuarios','Cuentas_UsuariosController');

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
#															                   #
########################################################################################
<?php

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('beneficios', 'BeneficiosController');
    Route::get('beneficios/{id}/destroy', [
		'uses' => 'BeneficiosController@destroy',
		'as'   => 'beneficios.destroy'
	]);

    Route::resource('categoria', 'CategoriaController');
    Route::get('categoria/{id}/destroy', [
		'uses' => 'CategoriaController@destroy',
		'as'   => 'categoria.destroy'
	]);
    Route::resource('valoracion', 'ValoracionController');
    Route::get('valoracion/{id}/destroy', [
		'uses' => 'ValoracionController@destroy',
		'as'   => 'valoracion.destroy'
	]);
	Route::get('carga','ValoracionController@carga_categoria');
    Route::resource('usuarios', 'UsersController');
    Route::get('usuarios/{id}/destroy', [
		'uses' => 'UsersController@destroy',
		'as'   => 'usuarios.destroy'
	]);

Route::get('usuarios/cambiar/{valor}', [
		'uses' => 'UsersController@cambiar',
		'as'   => 'usuarios.cambiar'
	]);
Route::put('usuarios/update_password/{valor}', [
		'uses' => 'UsersController@update_password',
		'as'   => 'usuarios.update_password'
	]);
    Route::resource('firmas', 'FirmasController');
    Route::get('firmas/{id}/destroy', [
		'uses' => 'FirmasController@destroy',
		'as'   => 'firmas.destroy'
	]);
	
	//Rutas para busqueda de datos para crear la solicitud
    Route::get('buscar_trabajador','SolicitudController@buscar_trabajador');
    Route::get('carga_categoria','SolicitudController@carga_categoria');
    Route::get('carga_beneficiario','SolicitudController@carga_beneficiario');
    Route::get('buscar_valor','SolicitudController@buscar_valor');

   
    Route::get('solicitud/{id}/destroy', [
		'uses' => 'SolicitudController@destroy',
		'as'   => 'solicitud.destroy'
	]);
    
    
    
     //Controlador principal de solicitud
    Route::resource('solicitud', 'SolicitudController');

    Route::resource('servicios', 'ServiciosController');
    Route::resource('rptsolicitud','RptSolicitudController');
    Route::resource('rptmensual','RptmensualController');
    Route::resource('rptlapso','rptlapsoController');

    route::resource('reembolso','ReembolsoController');
    Route::resource('anular', 'anularController');
   Route::get('reembolso/{id}/destroy', [
		'uses' => 'ReembolsoController@destroy',
		'as'   => 'reembolso.destroy'
	]);
  
});

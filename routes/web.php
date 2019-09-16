<?php


//RUTA PARA EL LOGIN
Route::get('/', function () {
    return view('auth/login');
})->middleware('guest');

//RUTAS DEL CRUD DE PROVEEDOR
Route::resource('local/proveedor','ProveedorController')->middleware('checkrole');
//RUTAS DEL CRUD DE CATEGORIAS

Route::get('local/categoria/inactivo','CategoriaController@inactivo')->middleware('checkrole');
Route::get('local/categoria/activar/{id}','CategoriaController@activar');

Route::resource('local/categoria','CategoriaController')->middleware('checkrole');

//RUTAS DEL CRUD DE PRODUCTO

Route::get('local/producto/inactivo','ProductoController@inactivo')->middleware('checkrole');
Route::get('local/producto/activar/{id}','ProductoController@activar')->middleware('checkrole');

Route::resource('local/producto','ProductoController')->middleware('checkrole');

//RUTAS DEL CRUD COMPRAS
Route::resource('local/compra','CompraController')->middleware('checkrole');
//RUTAS DEL CRUD USUARIO 
Route::resource('local/usuario','UsuarioController')->middleware('checkrole');
//RUTAS DEL CRUD DETALLE DE COMPRAS (
Route::resource('local/detalle_compra','DetalleCompraController')->middleware('checkrole');
//PARA MOSTRAR EL INICIO DEL ADMINISTRADOR
Route::get('/inicio','HomeController@inicio')->middleware('checkrole');
//PARA EL CRUD DE DATOS DE EMPRESA
Route::resource('local/empresa','EmpresaController')->middleware('checkrole')->middleware('checkrole');

//PARA CRUD DE CAJA_INICIO_CIERRE
Route::post('local/caja_inicio_cierre/corregir/ok/{id}','CajaInicioCierreController@corregir')->middleware('checkrole');
Route::get('local/caja_inicio_cierre/movimiento/ok/{id}','CajaInicioCierreController@movimiento')->middleware('checkrole');
Route::resource('local/caja_inicio_cierre','CajaInicioCierreController')->middleware('checkrole');

/** RUTAS PARA LA PARTE DE PUNTO VENTA  */
Route::get('venta/nuevo','VentaController@create')->middleware(['auth','autorizaVenta']);
Route::post('venta/ok', 'VentaController@store')->middleware('auth');

/** RUTAS PARA LA VISTA DE VENTAS */
Route::get('local/venta','VentaController@index')->middleware('checkrole');
Route::get('local/venta/{id}','VentaController@show')->middleware('checkrole');
Route::delete('local/venta/{id}','VentaController@destroy')->middleware('checkrole');

//RUTAS PARA ESTADISTICA
Route::get('local/estadistica/compra','EstadisticaController@mostrar_compra')->middleware('checkrole');
Route::get('local/estadistica/venta','EstadisticaController@mostrar_venta')->middleware('checkrole');
Route::get('local/estadistica/importar','EstadisticaController@importar_excel_producto')->middleware('checkrole');
Route::post('local/estadistica/im','EstadisticaController@importar_datos')->middleware('checkrole');

Route::get('local/estadistica/importar_categoria','EstadisticaController@importar_excel_categoria')->middleware('checkrole');
Route::post('local/estadistica/imp','EstadisticaController@importar_categoria')->middleware('checkrole');

//RUTAS PARA LA METODOLOGIA AGIL 
Route::resource('local/egreso','EgresoController')->middleware('checkrole');
Route::resource('local/add-stock','AddStockController')->middleware('checkrole');

//** AUTENTICACIÓN   */
//PARA LAS RUTAS DE AUTENTICACIÓN DEL LOGIN
Auth::routes();

//RUTA CREADA PARA CERRAR SESIÓN!
Route::get('/logout','Auth\LoginController@logout')->name('logout');






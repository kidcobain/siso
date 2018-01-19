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

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/lotes', 'Pruebacontroller@mostrarlotes');

//Route::get('/lote', 'Pruebacontroller@guardarlote');

Route::get('/lote', 'Pruebacontroller@guardarlote');

Route::get('/reposicion', 'Pruebacontroller@reposicionactualizar');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

Route::get('/tabla', function () {
    $proyecciones = App\Proyeccion::paginate(15);
	    return view('tabla', compact('proyecciones'));
});

Route::get('/pruebatabla', function () {
		$lotes = App\Lote::all();
	    return view('pruebatabla', compact('lotes'));
	});


Route::get('/home', 'HomeController@index')->name('home');
//Route::post('/datosAjax/InventarioPoliducto', 'HomeController@index')->name('home');
//Route::get('/sisor/public/datosAjax/InventarioPoliducto', 'HomeController@index')->name('home');
//Route::post('/sisor/public/datosAjax/InventarioPoliducto', return 'hello';

//Route::get('/sisor/public/datosAjax/InventarioPoliducto', 'PruebaController@prueba');

Route::get('/poliducto', 'Pruebacontroller@guardar');

//Route::get('/buscarlote/{numero}', 'Pruebacontroller@buscar');

Route::get('/fila/{numero}/eliminar', 'PruebaController@eliminar');

//Route::get('/fila/{numero}/eliminar', 'PruebaController@eliminar');

Route::get('/buscarlote',['uses' => 'PruebaController@buscar','as' => 'buscar']);
Route::get('/buscarlotefecha',['uses' => 'PruebaController@buscarfecha','as' => 'buscarfecha']);

});

/*
Route::group(['middleware' => ['permission:destroy_notes']], function () {
    Route::get('notes/{id}/destroy', 'NotesController@destroy')->name('notes.destroy');
});
*/

Route::resource('users', 'UserController');

Route::resource('roles', 'RoleController');

Route::resource('permissions', 'PermissionController');




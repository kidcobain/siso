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
    return view('welcome');
});

//Route::group(['middleware' => 'auth'], function () {

Route::get('/tabla', function () {
    $lotes = App\Lote::all();
	    return view('tabla', compact('lotes'));
});

Route::get('/pruebatabla', function () {
		$lotes = App\Lote::all();
	    return view('pruebatabla', compact('lotes'));
	});

Auth::routes();

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

//});




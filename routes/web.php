<?php

use App\Http\Middleware\PrimeiroMiddleware;



Route::get('/', function () {
    return view('index');
});

Route::get('/produtos', 'ControladorProduto@indexView');
Route::get('/categorias', 'ControladorCategoria@index');
Route::get('/categorias/novo', 'ControladorCategoria@create');
Route::post('/categorias', 'ControladorCategoria@store');
Route::get('/categorias/apagar/{id}', 'ControladorCategoria@destroy');
Route::get('/categorias/editar/{id}', 'ControladorCategoria@edit');
Route::post('/categorias/{id}', 'ControladorCategoria@update');


Route::get('/usuarios', 'UsuarioControlador@index')->middleware('primeiro');

<?php

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


Route::get('/usuarios', 'UsuarioControlador@index');

Route::get('/terceiro', function () {
    return "Passou pelo terceiro middleware";
})->middleware('terceiro:joao,19');


Route::get('/produtos1', 'ControladorProduto@showProducts');
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('contacto/{nombre?}/{edad?}', function($nombre = "Usuario", $edad = 2) {
    $frutas = ['manzana', 'pera', 'banana', 'naranja'];
    return view('contactos.contacto', [
        'frutas' => $frutas,
        'nombre' => $nombre,
        'edad' => $edad
    ]);
})->where([
    'nombre' => '[A-Za-z]+',
    'edad' => '[0-9]+'
])->name('contacto');


Route::get('rutadatos', function () {
    return view('datos');
})->name('ruta-datos');

Route::get('rutaalerta', function () {
    return view(view: 'vista_alert');
})->name('ruta-alerta');


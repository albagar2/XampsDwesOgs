<?php

use App\Http\Controllers\FrutasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

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
])->name('contacto')
->middleware('mayoredad:25');


Route::get('rutadatos', function () {
    return view('datos');
})->name('ruta-datos');

Route::get('rutaalerta', function () {
    return view(view: 'vista_alert');
})->name('ruta-alerta');


Route::prefix('/fruteria')->group(function () {

    Route::get('/frutas', [FrutasController::class, 'index'])->name('frutas.index');

    Route::get('/naranjas', [FrutasController::class, 'naranjas'])->name('frutas.naranjas');

    Route::get('/peras', [FrutasController::class, 'peras'])->name('frutas.peras');

    Route::post('/frutas', [FrutasController::class, 'recibeFrutas'])->name('frutas.recibeFrutas');
});
